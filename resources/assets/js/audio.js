let _ = require('underscore');
let av = require('av');
require('mp3');
let $ = require('jquery');
require('jplayer'); // modifies state, boo.

const State = {
  STOP: 'stopped',
  PLAY: 'playing',
  PAUSE: 'paused',
  WAIT: 'waiting'
};

let audio = {

  //** ================= **//
  //**  State / Options  **//
  //** ================= **//

  options: {
    stream: undefined,
    format: 'mp3',
    solution: 'html, aurora',
    auroraFormats: 'mp3'
  },

  hooks: {
    volume: undefined,
    toggle: undefined
  },

  shim: false, // are we using aurora?
  state: undefined,

  audio: undefined,
  player: undefined,

  //** ============== **//
  //**  Constructors  **//
  //** ============== **//

  init(defaults) {
    this.options = _.extend(this.options, defaults);
    this.shim = !!(Audio.canPlayType && Audio.canPlayType(this.options.format));
    this.state = State.WAIT;
  },

  createPlayer() {
    if (this.audio) {
      this.audio.remove()
    }

    this.audio = $('<div style="display:none"></div>');
    this.audio.jPlayer({
      solution: this.options.solution,
      auroraFormats: this.options.auroraFormats,
      supplied: this.options.format,
      preload: 'none',

      ready: () => {
        let media = {};
        media[this.options.format] = this.options.stream;

        this.audio.jPlayer('setMedia', media).jPlayer('play');
      }
    });
  },

  bind(hooks) {
    this.hooks = _.extend(this.hooks, hooks);
    this.hooks.toggle.addEventListener('click', this.events.toggle);
    this.hooks.volume.addEventListener('change', this.events.volume);
  },

  //** ================ **//
  //**  Audio Controls  **//
  //** ================ **//

  play() {
    if (this.state == State.PLAY) {
      return
    }

    this.createPlayer();
    this.state = State.PLAY;
  },

  stop() {
    if (this.state == State.STOP) {
      return
    }

    if (this.audio) {
      this.audio.jPlayer('pause');
      this.audio.jPlayer('clearMedia');
      this.audio.remove(); // removing the element also clears the media
    }

    this.state = State.STOP
  },

  volume(volume) {
    if (volume > 1 || volume < 0) {
      throw new Error('volume should be between 0 and 1')
    }

    if (this.player) {
      this.player.volume = parseFloat(volume)
    }
  },

  //** ======== **//
  //**  Events  **//
  //** ======== **//

  events: {
    toggle() {

      if (this.state == State.PLAY) {
        this.stop()
      } else {
        this.play()
      }

    },

    volume() {
      //
    }
  }
};

module.exports = audio;

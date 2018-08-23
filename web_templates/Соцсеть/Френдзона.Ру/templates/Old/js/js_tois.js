try{ window.jsProfiler && jsProfiler.loaded(); }catch(e){}

/* jsProfiler */

if (window.jsProfiler && window.performance && browser.chrome) (function(){
  $(window).load(function(){
    setTimeout(function(){
      var a = jsProfiler.arr, t = performance.timing, p = 'timing/';
      a[p + 'domainLookup'] = (t.domainLookupEnd - t.domainLookupStart) || 0;
      a[p + 'request'] = (t.responseStart - t.requestStart) || 0;
      a[p + 'response'] = (t.responseEnd - t.responseStart) || 0;
      a[p + 'domReady'] = (t.domContentLoadedEventEnd - t.navigationStart) || 0;
      a[p + 'load'] = ((t.loadEventEnd || t.loadEventStart) - t.navigationStart) || 0;
      a[p + 'connect'] = (t.connectEnd - t.connectStart) || 0;
    }, 0);
  });
})();

/**
Nav Module.
version 2.0
02.10.2012
*/
if ($.browser.msie && $.browser.version < 10) {

  window.__state = 0;

  history.pushState = history.replaceState = function(state, title, href){
    window.__state += 1;
    var l = nav2.get_location(href);
    location.hash = '#!' + l.pathname + l.search;
  };

  history.replaceState = function(state, title, href){
    window.__state += 1;
    var l = nav2.get_location(href);
    location.replace(nav2._location.pathname + nav2._location.search + '#!' + l.pathname + l.search);
  };

  window.onhashchange = function(){
    if (window.__state > 0) {
      window.__state -= 1;
      return;
    }
    window.__state = 0;
    nav2.go(location.href, { state: null });
  };

}

// nav2

var nav2 = (function(nav2, undefined){
  nav2.supported = window.history && history.pushState && history.replaceState && !navigator.userAgent.match(/((iPod|iPhone|iPad).+\bOS\s+[1-4]|WebApps\/.+CFNetwork)/);

  nav2.opts = {};
  nav2.eventer = new Eventer({ eventPrefix: '' });

  nav2.subnav = function(opts){

    if (!opts.check) opts.check = function(from, to){
      return nav2.in_map(opts.map, from.pathname) && nav2.in_map(opts.map, to.pathname);
    };

    nav2.opts[opts.name] = opts;

  };

  nav2.go = function(el, e, opts){
    var to = nav2.get_location(el), name = 'main', self = nav2.opts[name];
    if (
      (!window.inited) || // page inited
      (typeof el == 'object' && el.target) || // open links with target attr
      (e && checkEvent(e)) || // check event
      (!nav2.supported) || // is supported
      (nav2.long_request) || // long request
      (nav2.location.protocol !== to.protocol || nav2.location.hostname !== to.hostname) || // ignore cross origin links
      (nav2.location.pathname == to.pathname && nav2.location.search == to.search && to.hash) || // ignore hashchange
      (!self.check(nav2.location, to)) || // check location
      (!window.currentUser || !currentUser.userId) // check current user
    ) {
      // stat
      if (nav2.long_request) nav2.stat('pageload_long_request_tmp');

      // proceed
      if (!e && to.href !== undefined) location.href = to.href;
      return;
    }

    // prevent default for links
    if (e && e.state === undefined) pd(e);

    // is locked
    if (nav2.lock) return;

    if (((e && e.state !== undefined) || (opts && opts.back)) && flashback.check(to.href)) {
      if(opts && opts.popstate == true){
        safe_call('nav2 contextNav back', function(){ contextNav.clear('this_url') });
      }
      extDebugLog.push({type: 'flashback', data: false});
      nav2.flashback(to.href, e, opts);
    } else {
      extDebugLog.push({type: 'ajax', data: false});
      nav2.ajax(to.href, e, opts, nav2.in_map(self.new_map, to.pathname));
    }

    return true;
  };

  nav2.reload = function(){
    nav2.go(nav2.location.pathname + nav2.location.search);
  }

  nav2.flashback = function(href, e){
    var opts = flashback.get(href);

    // lock
    nav2.lock = true;

    // beforeSend
    nav2.beforeSend(href, e);

    setTimeout(function(){

      // referer
      nav2.referer = null;

      // state
      if (!e || e.state === undefined) {
        nav2.push(href, opts.title);
      } else {
        nav2.update(href, opts.title);
      }

      // callback
      nav2.onComplete(opts.content.find('script').remove().end(), null, opts, opts.title);

      // unlock
      nav2.lock = false;

      // load
      flashback.load(href);

    }, 0);

  };

  nav2.ajax = function(href, e, opts, inNewMap){
    var si = setTimeout(function(){
      nav2.stat('pageload_error_' + (nav2.__load_request ? 'stat' : 'ajax') + '_tmp');
      nav2.long_request = true;
      Faviconer.stopLoader();
    }, 10000);
    nav2.__load_request = 0;

    // lock
    nav2.lock = true;

    // preloader
    Faviconer.startLoader();
    // $('#content-inner').css('opacity', .5);

    // beforeSend
    nav2.beforeSend(href, e);

    var send = inNewMap ? _ajax.fspost : _ajax.post;

    // send
    send(href, { _nav: 1 }, function(html, status, data, title){

      // referer
      if (!e || e.state === undefined) {
        nav2.referer = { location: $.extend({}, nav2.location), title: document.title };
      } else {
        nav2.referer = null;
      }

      // state
      if (!e || e.state === undefined) {
        nav2.push(data.redirect_url || href, title);
      } else {
        nav2.update(data.redirect_url || href, title);
      }

      // callback
      nav2.onComplete(html, status, data, title);

      // unlock
      nav2.lock = false;
      nav2.long_request = false;

      // pageload
      clearTimeout(si);

      // check current location
      if (nav2.location.href != nav2.get_location(location.href)['href']) nav2.go(location.href, { state: null });

    }, true, false, function(a, b){ nav2.error('ajax ' + b + ' (' + a.status + '): ' + href); if (a.status != 0) location.href = href; }, function(){ nav2.__load_request = 1; });

  };

  nav2.beforeSend = function(href, e){
    var name = 'main', self = nav2.opts[name];
    self.beforeSend && safe_call('nav2 beforeSend', function(){ self.beforeSend(href, e); });
  };

  nav2.onComplete = function(html, status, data, title){
    var name = 'main', self = nav2.opts[name];

    // gc
    nav2.gc_exec();

    // callback
    self.onComplete && safe_call('nav2 onComplete', function(){ self.onComplete(html, status, data, title); });
  };

  nav2.push = function(href, title){
    var to = nav2.get_location(href);
    if (!nav2.supported || nav2.location.href == to.href) return;

    history.pushState(null, title || '', to.href);
    nav2.update(to.href, title);
  };

  nav2.replace = function(href, title){
    var to = nav2.get_location(href);
    if (!nav2.supported || nav2.location.href == to.href) return;

    history.replaceState(null, title || document.title, to.href);
    nav2.update(to.href, title);
  };

  nav2.update = function(href, title){
    if (title) document.title = htmlspecialchars_decode(title);
    nav2.location = nav2.get_location(href);
  };

  nav2.in_map = function(map, pathname){
    for (var i = 0, l = map.length; i < l; i += 1) if (typeof map[i] == 'string' ? pathname == map[i] : map[i].test(pathname)) return true;
    return false;
  };

  // stat

  nav2.stat = function(name){
    if (window.currentUser && (currentUser.userId % 100 < 4)) (new _jstat('Analytics')).add(name, 1).send();
  };

  // gc

  nav2.gc_cache = {};
  nav2.gc_queue = [];

  nav2.gc = function(fn, name){
    if (name) {
      if (nav2.gc_cache[name] !== undefined) nav2.gc_queue[nav2.gc_cache[name]] = null;
      nav2.gc_cache[name] = nav2.gc_queue.length;
    }
    nav2.gc_queue.push(fn);
  };

  nav2.gc_exec = function(){
    for (var a = nav2.gc_queue, i = a.length - 1; i >= 0; i -= 1) a[i] && safe_call('nav2 gc', a[i]);

    nav2.gc_cache = {};
    nav2.gc_queue = [];
  };

  // location

  nav2.get_location = (function(a, l){
    return function(el){
      if (typeof el == 'string') {
        a.href = el;
      } else if (el && el.href) {
        a.href = el.href;
      } else return {};

      if (a.hash.substr(0, 2) == '#!') a.href = a.hash.substring(2);

      var protocol = a.protocol && a.protocol != ':' ? a.protocol : l.protocol,
          hostname = a.hostname || l.hostname,
          pathname = a.pathname.replace(/^\/?/, '/').replace(/\/?$/, '/'),
          search = a.search,
          hash =  a.hash || (a.href.charAt(a.href.length - 1) == '#' ? '#' : '');

      return {
        protocol: protocol,
        hostname: hostname,
        pathname: pathname,
        search: search,
        hash: hash,
        href:  protocol + '//' + hostname + pathname + search + hash
      };
    }
  })(document.createElement('a'), { protocol: location.protocol, hostname: location.hostname });

  nav2.location = nav2._location = nav2.get_location(location.href);

  // query params

  nav2.getParam = function(name){
    return q2obj(nav2.location.search.substring(1))[name];
  };

  nav2.setParam = function(name, value, pushToHistory){
    var q = q2obj(nav2.location.search.substring(1)), loc = nav2.location;

    if (typeof name == 'string') {
      if (value === false) {
        delete q[name];
      } else {
        q[name] = value;
      }
    } else {
      $.extend(q, name);
    }

    nav2.eventer.emit('setParam', {url: loc.pathname + '?' + obj2q(q) + loc.hash});
    nav2[pushToHistory ? 'push' : 'replace' ](loc.pathname + '?' + obj2q(q) + loc.hash);
  };

  nav2.deleteParam = function(name, pushToHistory){
    nav2.setParam(name, false, pushToHistory);
  };

  // error

  nav2.error = function(msg){
    debugLog('nav2 ' + msg);
  };

  return nav2;

})({});

$(window).bind('popstate', function(e){
  nav2.go(location.hash.substr(0, 2) == '#!' ? location.hash.substring(2) : location.href, e['originalEvent'], {popstate: true});
});

/* main nav */

nav2.subnav({
  name: 'main',
  parent: '',
  map: [
    '/',
    /^\/user\/(\d+\/)?((friends|blog|info)\/)?$/,
    /^\/user\/\d+\/albums\/$/,
    /^\/user\/\d+\/giftroom\/$/,
    /^\/user\/\d+\/album\/\d+\/((photos|settings|comments)\/)?(\d+\/)?$/,
    /^\/user\/\d+\/board\/\d+\/$/,
    /^\/\d+\/$/,
    /^\/u\/[a-z\d-]+\/$/i,
    /^\/pacman\/(apps|news)\//,
    '/album/new/',
    /^\/partner\/offersapp\/.*/i,
    /^\/friends\//i,
    /^\/userinfo\/room\//i,
//  /^\/app\/[a-z\d]+\/$/i,
    /^\/interest\//i,
    '/usercontact/',
    '/interests/services/',
    '/interests/people/',
    '/interests/favorite/',
    '/people/',
    '/people/index/',
    '/people/main/',
    '/people/friends/',
    '/people/dating/',
    '/people/icu/',
    /^\/people\/interests\/.*/i,
    '/profile/',
    '/meeting/',
    /^\/meeting\/index\/.*/i,
    /^\/meeting\/apps\/.*/i,
    '/meeting/main/',
    '/meeting/photo/rates/',
    '/search/',
    '/leader/',
    '/community/',
    /^\/community\/category\/\d+/i,
    /^\/community\/(my|new|manage)\/$/i,
    '/community/new/',
    /^\/public\/.*/i,
    /^\/games\//i,
    /^\/meetup\//i,
    '/newyear/',
    /^\/holiday\//i,
    /^\/support\/feedback\//i,
    /^\/support\/feedbackv3\//i,
    '/vip/',
    '/marketplace/sale/',
    '/bomond/',
    /^\/bomond\/index\/.*/i,
    /^\/play\/.*/i,
    '/market/springfair/',
    '/pacman/news/',
    '/pacman/start/',
    '/daily/news/',
    '/daily/news/interest/',
    '/daily/comments/',
    '/team/',
    /^\/team\/index\/.*/i,
    /^\/team\/may\/.*/i,
    /^\/team\/firtree\/.*/i,
    '/about/',
    /^\/about\/.*/i,
    /^\/photocontest\/.*/i,
    /^\/rating\/.*/i,
    /^\/phototags\/.*/i,
    /^\/sticker\/.*/i,
    /^\/finance\/index\/.*/i,
    /^\/pets\/.*/i,
    /^\/vip\/.*/i,
    /^\/ask\/.*/i,
    /^\/video2\/.*/i,
    /^\/play\/feed\/(board\/)?/i,
    /^\/usernews\/feed\//i
  ],
  // if u wanna correct error handling
  new_map: [
    /^\/user\/(\d+\/)?((friends|blog|info)\/)?$/,
    /^\/\d+\/$/,
    /^\/u\/[a-z\d-]+\/$/i
  ],
  check: function(from, to){ var m = nav2.opts.main.map; return ge('content-inner') && nav2.in_map(m, from.pathname) && nav2.in_map(m, to.pathname); },
  beforeSend: function(href, e){

    // flashback
    flashback.save(nav2.location.href);

    // scroll
    if (e && e.state !== undefined) scrollToY(0);

  },
  onComplete: function(html, status, data){

    // streamer
    if (window.streamer) streamer.unsubscribe(~257);

    //topper
    if (window.topper) topper.clear();

    // scrollable
    scrollable.reset();
    scrollToY(0);

    // preloader
    Faviconer.stopLoader();
    // $('#content-inner').css('opacity', 1);

    //content
    $('#node-heap').empty();
    $('#content-inner').replaceWith('<div id="content-inner"></div>');
    $('#content-inner').html(html);

    // scroll
    data.scrollTop && scrollToY(data.scrollTop);

    // header link
    $('#header').children().removeClass('on');
    if (data.active_header_link) $('#header a[rel='+ data.active_header_link +']').addClass('on');

    // noty
    if (data.noty) noty.update(data.noty);

    safe_call('nav2 contextNav', contextNav.refresh);

      // google analytics
    if (window._gaq && data.ga_page_link) _gaq.push(['_trackPageview', data.ga_page_link]);

    // last visit ico
    if (data._last_service){
        if (!interestsBase.services.visibleServices[data._last_service]) interestsBase.reloadList();
        else interestsBase.services.lastVisitIco(data._last_service);
    }

    // king
    if(window.king && typeof(data._trgt_sid) !== 'undefined') king.rotator.sid = data._trgt_sid;
    if (window.king && king.rotator.hasOwnProperty('timing') && fsNow() - king.rotator.timing > 2000) {
      king.rotator.timing = fsNow();
      king.rotator.multiRenew();
    }

    // CPAE
    window.CPAE && CPAE.check();

    // LI counter
    (new Image()).src = "http://counter.yadro.ru/hit;fotostrana?r"+escape(document.referrer)+((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+";"+Math.random();

  }
});

if (window.isOurIp) {
    nav2.opts.main.map.push('/contest/')
}

$(document).click(function(e){
  var target = e.target;
  extDebugAddClick(target);
  if (target.nodeName.toLowerCase() == 'a' || (target = $(target).closest('a')[0])) nav2.go(target, e.originalEvent);
});

/**
Flashback Module.
version 2.6
05.04.2013
*/
var flashback = function(opts){
  flashback.__opts = $.extend({}, opts);
};

(function(fb){

  fb.queue = [];
  fb.queue_limit = 5;

  fb.save = function(href){

    if (!flashback.__opts) return;

    for (var i = 0, opts = flashback.__opts, a = flashback.queue, l = a.length; i < l; i += 1) if (a[i].href == href) {
      a.splice(i, 1);
      break;
    }

    if (fb.queue_limit == a.length) a.shift();

    opts.title = document.title;
    opts.href = href;
    opts.data = {};
    if (scrollable.stack.length > 1) {
        // If something is overlaying the main content, we need to save content-wrap offset instead of scrollTop value
        opts.scrollTop = -parseInt($('#container-wrap').css('top'));
    } else {
        opts.scrollTop = fs.scrollTop;
    }
    opts.active_header_link = $('#header').children().filter('.on').attr('rel');
    opts.content = $('#content-inner');

    a.push(opts);

    safe_call('flashback - save', function(){
      opts.save && opts.save(opts.data);
    });

    flashback.__opts = null;

  };

  fb.load = function(href){
    var opts = fb.get(href);

    safe_call('flashback - load', function(){
      opts.load && opts.load(opts.data);
    });
  };

  fb.indexOf = function(href){
    for (var i = 0, a = flashback.queue, l = a.length; i < l; i += 1) if (a[i].href == href) return i;
    return -1;
  };

  fb.get = function(href){
    var idx = fb.indexOf(href);
    return idx < 0 ? false : fb.queue[idx];
  };

  fb.check = function(href){
    return fb.indexOf(href) >= 0;
  };

})(flashback);

/* noty module 2.0 */

var noty = (function(noty){

  noty.notifi = {};
  noty.time_limit = 30000;

  noty.update = function(notifi){

    if (notifi) {
      noty.last_update = fsNow();
      for (var i in notifi) noty.setCounter(i, notifi[i]);
    } else {
      if (fsNow() - noty.last_update < noty.time_limit) {
        clearTimeout(noty.si);
        noty.si = setTimeout(function(){ noty.update(); }, noty.time_limit - (fsNow() - noty.last_update));
      } else {
        clearTimeout(noty.si);
        $.getJSON('/pacman/ajax/getCounters/', function(data){
          if (!data || !data.ret || !data.noty) return;
          noty.update(data.noty);
        });
      }
    }

  };

  noty.getCounter = function(name){
    var c = parseInt(noty.notifi[name]);
    return (isNaN(c) ? parseInt($('.noty-' + name).html()) : c) || 0;
  };

  noty.setCounter = function(name, count, opts){
    var c = parseInt(count) || 0;
    noty.notifi[name] = c = (c < 0 ? 0 : c);

    $('.noty-' + name).html(c ? (c < 100 ? c : '99+') : 0)[(c ? 'add' : 'remove') + 'Class']('on');
    if (opts && opts.global) lc('noty', { action: 'setCounter', name: name, count: count });
  };

  noty.addToCounter = function(name, count, opts){

    var c = parseInt(count) || 0, prefix = name.split('_')[0];
    if (!c) return;

    if (name != prefix) noty.addToCounter(prefix, c);
    noty.setCounter(name, noty.getCounter(name) + c);

    if (opts && opts.global) lc('noty', { action: 'addToCounter', name: name, count: count });
  };

  noty.onreceive = function(data){
    if (!data || !data.action || !data.name || !noty[data.action]) return;
    noty[data.action](data.name, data.count);
  };

  return noty;

})({});

/* title module 1.3 */

var titles = new function () {
    var self = this;

    self.onreceive = function (data) {
        if (data && data.action && self[data.action]) self[data.action](data.data);
    };

    self.rotate = function (title, favicon) {
        var data = {
            title: title,
            favicon: void 0 == favicon  ? 'default' : favicon
        };

        self._lc('titles', { action: '_rotate', data: data });
    };

    self.reset = function () {
        self._lc('titles', { action: '_reset', data: true });
    };

    self._lc = function (callback, data) {
        if (lc.supported && !streamer.is_server) lc(callback, data);
        self[data.action](data.data);
    };

    self._rotate = function (data) {
        if (!self._title) self._title = document.title;
        if (!self._favicon) self._favicon = 'default';

        self._newTitle = data.title;
        self._newFavicon = data.favicon;

        self._rotator();
    };

    self._rotator = function () {
        if (!self._rotating) {
            self._rotating = true;

            if (self._newTitle && self._title && self._favicon && self._newFavicon) {
                document.title = (self._title == document.title ? self._newTitle : self._title);
                self._favicon = (self._favicon == 'default' ? self._newFavicon : 'default');
                Faviconer.setFavIcon(self._favicon);
            }

            clearTimeout(self._timeout);
            self._timeout = st(function () {
                self._rotating = false;
                self._rotator();
            }, 1001);
        }
    };

    self._reset = function () {
        if (!self._resetting) {
            self._resetting = true;

            st(function () {
                if (self._title) document.title = self._title;
                if (self._timeout) clearTimeout(self._timeout);

                self._rotating = false;
                self._favicon = 'default';
                Faviconer.setFavIcon(self._favicon);

                st(function () {
                    self._resetting = false;
                }, 1001);
            }, 1001);
        }
    };
};

/* sounds module 1.1 */

var sounds = new function(){

  var sounds = this;

  sounds.enable = function(force){
    if (!force) lc('sounds', { action: 'enable', data: true });
    sounds.enabled = true;
  };

  sounds.disable = function(force){
    if (!force) lc('sounds', { action: 'disable', data: true });
    sounds.enabled = false;
  };

  sounds.onreceive = function(data){
    if (data && data.action && sounds[data.action]) sounds[data.action](data.data);
  };

  sounds.play = function(opts){
    if (!lc.supported || streamer.is_server) {
      sounds._play(opts);
    } else {
      lc('sounds', { action: '_play', data: opts });
    }
  };

  sounds._play = function(opts){
    if ((typeof lc != 'undefined' && lc.supported && !streamer.is_server) || !sounds.inited || !sounds.enabled || fsNow() - (sounds.time || 0) < 5000) return;
    sounds.time = fsNow();
    try {
      ge('soundsSWF').play('noty');
    } catch(e) { setTimeout(function(){if(ge('soundsSWF').play) {ge('soundsSWF').play('noty');} }, 200); }
  };

  $(window).load(function(){
    $('#system_service').append('<div id="soundsSWF"></div>');
    swfobject.embedSWF( window.staticDomain + '/swf/sounds.swf?2', 'soundsSWF', '10', '10', '10.0.0', staticDomain + '/swf/expressInstall.swf', {}, { menu: 'false', wmode: 'window', allowScriptAccess: 'always' }, {}, function(e){ if (e && e.success) sounds.inited = true; sounds._play(); } );
  });

};

/* streamer handler */

if (window.streamer) streamer.subscribe('main', function(type, data){
  if (type == 'pacman') {
    if (data.apps) {
      for (var app_id in data.apps) {
        noty.addToCounter('pacman_' + app_id, data.apps[app_id]);
      }
    } else {
      noty.addToCounter('pacman_' + data.app_id, data.app_count);
    }
  }

  if (type == 'newfriends') noty.addToCounter('friends', 1);
  if (type == 'friendsaccept' || type == 'friendsdecline') noty.addToCounter('friends', -1);
  if (type == 'news' || type == 'newguests' || type == 'newlikes') {
      noty.update();
  }

  // usercontact
  if (type == 'newmsg') {
      if (!window.usercontact || !usercontact.socket.connected) {
        noty.addToCounter('mess_u' + data.author_id, 1);
        streamer.is_server && sounds.play();
      }
  }
  if (type == 'usercontact_chat') {
    if (!window.usercontact || !usercontact.socket.connected) {
      if (data && data.event == 'read') noty.addToCounter('mess_u' + data.to, -data.count);
    }
  }

  if (type == 'url_parser') {
    if (window.fsPin && fsPin.currentParseTaskId == data.task) {
        fsPin._parseCompleteCallback(data);
    }
    if(typeof messageFormEventer !== 'undefined'){
        messageFormEventer.emit('parseComplete', data);
    }
  }
  if (type == 'adventures') {
      if(window.isOurIp) console.log(data);
  }
});

/* scrollable block */

var scrollable = function(opts){
  scrollable.opts[opts.name] = opts;
  if (!scrollable.stack.length) scrollable.stack.push(opts.name);
};

(function(scrollable){

    scrollable.opts = {};
    scrollable.stack = [];

    scrollable.push = function(name){
        var stack = scrollable.stack, opts = scrollable.opts, below = opts[stack[stack.length - 1]], push = opts[name];
        if(push.isUnique){
            for(var i in stack){
                if(stack[i] == name){
                    below.onbelow.apply(below, []);
                    stack.splice(i, 1);
                    stack.push(name);
                    push.onover();
                    return;
                }
            }
        }
        below.onbelow.apply(below, []);
        scrollToY(0);
        push.onpush && push.onpush.apply(push, []);
        stack.push(name);
    };

    scrollable.pop = function(uid){
        var stack = scrollable.stack,
            opts = scrollable.opts, pop, over, i;
        if(uid && typeof opts[uid] !== 'undefined'){
            pop = opts[uid];
            for(i=0; i<stack.length; i++){
                if(stack[i] == uid){
                    if(i < stack.length-1){
                        stack = stack.splice(i, 1);
                        pop.onpop && pop.onpop.apply(pop, []);
                        return true;
                    }
                }
            }
        }

        pop = opts[stack[stack.length - 1]];
        over = opts[stack[stack.length - (stack.length > 1 ? 2 : 1)]];
        pop.onpop && pop.onpop.apply(pop, []);
        scrollToY(0);
        if (stack.length > 1) stack.pop();
        over.onover.apply(over, []);
    };

  scrollable.reset = function(){
    for (var i = 0, l = scrollable.stack.length - 1; i < l; i += 1) scrollable.pop();
  };

  window.ffScrollableFlashHack = $.browser.mozilla && parseInt($.browser.version) < 13; // нужен ли костыль для флеша в FF младше 13-й версии
  scrollable({
    name: 'container-wrap',
    onpop: function(){},
    onpush: function(){},
    onbelow: function(){
      var appNeedHide = typeof appHideRequired !== 'undefined' && appHideRequired && typeof hideApp == 'function';
      if (!ffScrollableFlashHack || !appNeedHide) {
        $('#' + this.name).addClass('fixed').css('top', -fs.scrollTop);
      }
      topper.destroy();
      if(appNeedHide)
        hideApp();
    },
    onover: function(){
        var t = $('#' + this.name),
          top = t.css('top');
      topper.init();
      var appNeedHide = typeof appHideRequired !== 'undefined' && appHideRequired && typeof hideApp == 'function';
      if (!ffScrollableFlashHack || !appNeedHide) {
        t.removeClass('fixed').css('top', 0);
      }
      if(appNeedHide)
        showApp();
      scrollToY(-parseInt(top));
    }
  });

})(scrollable);

/* friendship */

var friendship = (function(friendship){

  friendship.get = function(url, id, callback, opts) {
    var params = {
      friendId: id,
      'ftoken-all': window.fsft
    };
    $.extend(params, opts)

    $.getJSON(url, params, function(response) {
      if (response && response.error && response.error == 'ignor') {
        iPopup.confirm(response.html, $.extend(true, [{
          title: 'Отмена',
          defaultEnter: true,
          myclass: ''
        }, {
          title: 'Убрать и продолжить',
          myclass: 'btn-blue',
          callback: function() {
            delFromBlacklist(id, null, function() {
              $('#profile-blacklist-add').removeClass('d-n');
              $('#profile-blacklist-del').addClass('d-n');

              friendship.get(url, id, callback, opts);
            });
          }
        }]), {onclose: function() {
          response.html = '';
          callback && callback(response);
        }});
        return;
      }

      callback && callback(response);
    });
  };

  friendship.request = function(id, callback, opts) {
    friendship.get('/usercontact/backend/friendshipRequest/', id, callback, opts);
  };

  friendship.cancel = function(id, callback, opts) {
    friendship.get('/usercontact/backend/friendshipCancel/', id, callback, opts);
  };

  friendship.revoke = function(id, callback, opts) {
    friendship.get('/usercontact/backend/friendshipRequestRevoke/', id, callback, opts);
  };

  friendship.confirm = function(id, callback, opts) {
    friendship.get('/usercontact/backend/friendshipRequestConfirm/', id, callback, opts);
  };

  friendship.refuse = function(id, callback, opts) {
    friendship.get('/usercontact/backend/friendshipRequestRefuse/', id, callback, opts);
  };

  return friendship;

})({});

var interestsBase = {
    ajaxProcessed: false,
    services: {
        visibleServices: {},
        ajaxParams: function (targetId, params) {
            return $.extend({}, { isAjax: 1, appId: targetId }, params);
        },
        settingsWasOpened : function(params) {
            $.get('/interests/services/settingsMenuWasOpened/', this.ajaxParams(0, params));
        },
        hideService: function(el, targetId, params) {
            if (interestsBase.ajaxProcessed) {
                return;
            }
            interestsBase.ajaxProcessed = true;

            $.get('/interests/services/hideServiceFromList/', this.ajaxParams(targetId, params), function(res){
                interestsBase.ajaxProcessed = false;

                if (res.ret != 1) {
                    fs.notify(res.message);
                    return;
                }

                el = $(el).parents('.interest-item');
                el.addClass('h');
                el.remove();

                //TODO:Скрывать элемент из основного (центрального) списка

                interestsBase.reloadList();
            }, 'JSON');
        },
        toggleFavorite: function(el, targetId, params) {
            if ($(el).hasClass('favorite')) {
                this.removeFromFavorite(el, targetId, params);
            } else {
                this.addToFavorite(el, targetId, params);
            }
        },
        addToFavorite: function(el, targetId, params) {
            if (interestsBase.ajaxProcessed) {
                return;
            }
            interestsBase.ajaxProcessed = true;

            $.get('/interests/services/addToFavorite/', this.ajaxParams(targetId, params), function(res){
                interestsBase.ajaxProcessed = false;

                if (res.ret != 1) {
                    fs.notify(res.message);
                    return;
                }

                el = $(el);
                el.html('Убрать из избранного');
                el.addClass('favorite');

                //TODO:Добавить элемент в избранное основного (центрального) списка

                // Перегрузить лист
                interestsBase.reloadList();
            }, 'JSON');
        },
        removeFromFavorite: function(el, targetId, params) {
            if (interestsBase.ajaxProcessed) {
                return;
            }
            interestsBase.ajaxProcessed = true;

            $.get('/interests/services/removeFromFavorite/', this.ajaxParams(targetId, params), function(res){
                interestsBase.ajaxProcessed = false;

                if (res.ret != 1) {
                    fs.notify(res.message);
                    return;
                }

                el = $(el);
                el.html('Добавить в избранное');
                el.removeClass('favorite');

                //TODO:Удалить элемент из избранное основного (центрального) списка

                // Перегрузить лист
                interestsBase.reloadList();
            }, 'JSON');
        },
        settingsNotAvailable: function () {
            iPopup.alert('Временно недоступно.');
        },
        hidePromo: function(appUid){
            $.get('/interests/services/hidepromo/', this.ajaxParams(appUid), function(){
                $('#interests-promo').slideUp();
            });
        },
        lastVisitIco: function(serviceStr){
            var list = $('#side-service');
            var ico = $('.interest-item .item-lastvisit-icon', list);
            if (!ico.length){
                return interestsBase.reloadList();
            }
            var item = $('#interest-item-' + serviceStr, list);
            if ($('.item-fav-icon', item).length){
                ico.remove();
            } else {
                $('a', item).prepend(ico);
            }
        }
    },
    people: {
        settingsWasOpened: function() {
            $.get('/interests/people/settingsmenuwasopened/', {isAjax: 1});
        },

        addToFavorite: function(el, targetId, source) {
            if (interestsBase.ajaxProcessed) {
                return;
            }
            interestsBase.ajaxProcessed = true;

            el = $(el);
            var parent = el.parents('.interest-item');

            el.addClass('h');
            parent.find('.people-fav-del').removeClass('h');

            addToFavorite(targetId, el, function(res, item) {
                item = $(item);
                if (!res || res.ret != 1) {
                    // что-то не так - возвращаем обратно
                    item.removeClass('h');
                    parent.find('.people-fav-del').addClass('h');
                }
                interestsBase.ajaxProcessed = false;
            }, source);
        },
        removeFromFavorite: function(el, targetId, source) {
            if (interestsBase.ajaxProcessed) {
                return;
            }
            interestsBase.ajaxProcessed = true;

            el = $(el);
            var parent = el.parents('.interest-item');

            el.addClass('h');
            parent.find('.people-fav-add').removeClass('h');

            delFromFavorite(targetId, el, function(res, item) {
                item = $(item);
                if (!res || res.ret != 1) {
                    // что-то не так - возвращаем обратно иконку и текст
                    item.removeClass('h');
                    parent.find('.people-fav-add').addClass('h');
                }
                interestsBase.ajaxProcessed = false;
            }, source);
        },
        hideUser: function(el, targetId) {
            if (interestsBase.ajaxProcessed) {
                return;
            }
            interestsBase.ajaxProcessed = true;

            el = $(el);

            var parent = el.parents('.interest-item');
            var ajaxParams = {
                isAjax: 1,
                targetId: targetId,
                fromLeftBlock: 1
            };

            parent.addClass('h');

            $.get('/interests/people/hideuserfromlist/', ajaxParams, function(res){
                interestsBase.ajaxProcessed = false;
                if (!res || res.ret != 1) {
                    // что-то не так - возвращаем обратно иконку и текст
                    parent.removeClass('h');
                } else {
                    parent.remove();
                    interestsBase.reloadList();
                }
            }, 'JSON');
        },
        manageHiddenPeople: function (opts) {
            return peopleManagePopup($.extend({
                title: 'Выберите людей',
                myclass: 'list-manage-popup people-manage-popup interest-people-manage-popup font-large',
                listTitles: ['Все интересные люди', 'Скрытые люди'],
                emptyMessages: ['Список пуст.', 'Вы можете выбрать людей, которых хотите скрыть. Они больше не будут выводиться в блоке и на странице Интересные мне люди.'],
                loadAjaxUrl: '/UsersManager/InterestsPeople/getPopup/',
                saveAjaxUrl: '/UsersManager/InterestsPeople/savePopup/',
                onSaveSuccess: function (res) {
                    if (this.isChanged()) {
                        if (window.interestPeople && interestPeople.isViewingPage) {
                            interestPeople.appendToList(interestPeople.listView, true);
                        }
                        interestsBase.reloadList();
                    }

                    listManagePopup.prototype.onSaveSuccess.call(this, res);
                },
                saveAjaxParams: function () {
                    return $.extend({
                        ref: this.ref
                    }, listManagePopup.prototype.saveAjaxParams.apply(this, arguments));
                },
                loadAjaxParams: function () {
                    return $.extend({
                        ref: this.ref
                    }, listManagePopup.prototype.loadAjaxParams.apply(this, arguments));
                }
            }, opts));
        }
    },
    reloadList: function() {
        if (interestsBase.ajaxProcessed) {
            return;
        }
        interestsBase.ajaxProcessed = true;
        $.get('/interests/index/reloadLeftBlock/', {isAjax: 1}, function(res){
            interestsBase.ajaxProcessed = false;
            if (res && res.ret == 1) {
                var peopleBlock = $('#side-people');
                var servicesBlock = $('#side-service');
                var scrollBlock = $('#side-scroll');
                if (peopleBlock.size() > 0) {
                    servicesBlock.remove();
                    if (scrollBlock.size() > 0) {
                      scrollBlock.remove();
                    }
                    peopleBlock.replaceWith(res.html);
                } else if (servicesBlock.size() > 0) {
                    peopleBlock.remove();
                    if (scrollBlock.size() > 0) {
                      scrollBlock.remove();
                    }
                    servicesBlock.replaceWith(res.html);
                }
            }
        }, 'JSON');
    }
};

/* search module 2.0 */

var fsSearch = function(id, opts){
  var self = this;
  self.wrap = $('#' + id);
  self.input = self.wrap.find('input');
  self.search_val = self.input.val();
  $.extend(self, opts);

  self.input.bind('keydown', function(event){ self.onkeydown(event) });
};

(function(search, proto){

  proto.onkeydown = function(event){
    var self = this;
    if (event.keyCode == 27) {
      self.input.blur();
      self.cancel();
      return;
    }
    clearTimeout(self.ti);
    self.ti = setTimeout(function(){ self.update(); }, 10);
  };

  proto.val = function(value){
    if (value === undefined) return trim(this.input.val());
    this.input.val(value);
  };

  proto.update = function(force){
    var self = this, val = self.val();

    if (val) {
      self.wrap.addClass('process').addClass('filled');
    } else {
      self.cancel();
      return;
    }

    if (!force) {
      if (self.search_temp_val != val) {
        self.search_temp_val = val;
        clearTimeout(self.ti);
        self.ti = setTimeout(function(){ self.update(); }, 500);
      } else {
        self.search_temp_val = '';
        self.update(true);
      }
      return;
    }

    if (self.search_val == val) {
      self.wrap.removeClass('process');
    } else {
      self.search_val = val;
      self.onsearch && self.onsearch(val);
    }

  };

  proto.cancel = function(){
    var self = this;
    self.search_val = '';
    self.val('');
    self.wrap.removeClass('filled').removeClass('process');
    clearTimeout(self.ti);

    self.oncancel && self.oncancel();
  };

})(fsSearch, fsSearch.prototype);

/* ddb */

var ddb = (function(ddb){
    var ddbTimerOpen = 0,
        ddbTimerElClose = {};
    ddb.onclick = function(el, event){
        $(el).toggleClass('open-menu');
    };
    ddb.onmouseleave = function(el, event, opts){
        opts = $.extend({
          timeout: 300
        }, opts);
        clearTimeout(ddbTimerOpen);
        var ddbcid =  Math.floor(Math.random() * 1000000);
        $(el).data('ddbcid', ddbcid);

        ddbTimerElClose[ddbcid] = st(function() {
            $(el).removeClass('open-menu');
        }, opts.timeout);
    };
    ddb.onmouseenter = function(el, event){
        var ddbcid = $(el).data('ddbcid') || 0;
        if (ddbTimerElClose[ddbcid]) {
          clearTimeout(ddbTimerElClose[ddbcid]);
        }
    };
    ddb.openOnHover = function(el, event, timeout){
        var ddbcid = $(el).data('ddbcid') || 0;
        if (ddbTimerElClose[ddbcid]) {
          clearTimeout(ddbTimerElClose[ddbcid]);
        }
        var ddbTimerOpen = setTimeout(function(){
            $(el).addClass('open-menu');
        }, timeout);
    };
    return ddb;
})({});

function Scroller(params){
    var onScroll = {},
        scrollTo = {},
        offset = 200,
        me = {};
    var init = function(params, scope){
        me = scope;
        me.uuid = ++Scroller.uuid;

        if(params.selector){
            me.elem = $(params.selector);
            me.scrollTop = function(){ return me.elem.scrollTop(); };
            me.height = function(){ return me.elem.height(); };
        } else {
            me.elem = $(window);
            me.scrollTop = function(){ return fs.scrollTop };
            me.height = function() { return fs.windowH; };
            // if ie
        }

        if(params.offset)
            offset = params.offset;

        if(params.scrollTo){
            scrollTo = $(params.scrollTo);
            scrollTo.myScroll = function(){ return scrollTo.offset().top };
        } else {
            if(params.selector)
                scrollTo.myScroll = function(){ return me.elem[0].scrollHeight;};
            else
                scrollTo.myScroll = function(){ return document.documentElement.scrollHeight};
        }

        if(params.onScroll) {
            onScroll = function() {
                if( scrollTo.myScroll() - (me.scrollTop() + me.height())  < offset )
                    params.onScroll(me);
            };
            me.elem.bind('scroll.scroller'+me.uuid, function(){
                if(!window.lockScroller) me.onScrollTimer = setTimeout(onScroll, 0); // hack для того, чтобы в Хроме бралось актуальное значение scrollTop
            });
            $(onScroll);
        } else {
            return false;
        }

        nav2.gc(function(){ me.destroy(); });
        return me;
    };

    return init(params, this);
}

(function(Scroller, proto){
    Scroller.uuid = 0;

    proto.destroy = function(){
        clearTimeout(this.onScrollTimer);
        this.elem.unbind('scroll.scroller'+this.uuid);
    };
})(Scroller, Scroller.prototype);

var showPhotoInitLock = false;
function showPhoto(el, event, callback){
    if(checkEvent(event)){
        return;
    } else {
        cancelEvent(event);
    }
    var th = $(el);
    if(!showPhotoInitLock) {
        showPhotoInitLock = true;
        _ajax.get('/userphoto/ajax/showFsimp/', {}, function(html, status, data){
            if (data.state == 1) {
                showUploadMainPhotoPopup();
                showPhotoInitLock = false;
            } else {
                $('body').append(data.html);
                fsimp.imgInit();
                fsimp.imgShow(th, callback);
            }
        });
        return false;
    } else if (typeof fsimp !== 'undefined') {
        fsimp.imgShow(th, callback);
    }
}

var AnyTooltipStack = [];
var AnyTooltipGc = function(){
    if(AnyTooltipStack.length)
        $.each(AnyTooltipStack, function(){
            var t = this[0].tooltip;
            if (t) t.destroy();
        });
};
function AnyTooltip(element, config){
    var me = {};
    var init = function(element, params){
        me.content_is_func = false;
        me.mywidth = false;
        me.animate_open = false;
        me.animate_close = false;
        me.myclass = false;
        me.on_open_callback = false;
        me.on_close_callback = false;
        me.wrapper = false;
        me.show_timer = 0;
        me.show_delay = 300;
        me.show_duration = 200;
        me.show_distance = 30;
        me.hide_timer = 0;
        me.hide_delay = 300;
        me.hide_duration = 200;
        me.hide_distance = 30;
        me.no_close = false;
        me.is_visible = false;
        me.already_hidden = false; // hack этот флаг устанавливается в true в самом начале выполнения delayedTooltipHide, и снова возвращается в false в delayedTooltipShow.
                                   // Если флаг установлен в true, то showTooltip не станет показывать тултип, но если контент тултипа возвращается функцией, то она все равно будет выполнена.
                                   // Это сделано для того, чтобы тултип не стал показываться в случае, если функция, возвращающая контент, использует асинхронный запрос, и он уже послан, но пользователь убрал курсор с искомого элемента.
        me.node_heap = '#node-heap';

        /* load params */
        if(element)
            me.element = $(element);
        else return false;

        if( params.content ){
            if(params.content.html){
                me.content = params.content.html;
            } else if(params.content.func){
                me.content_is_func = true;
                me.content = params.content.func;
            } else return false;
        } else return false;

        if( params.style ){
            if(params.style.width)
                me.mywidth = params.style.width;
            if(params.style.animate_open)
                me.animate_open = params.style.animate_open;
            if(params.style.animate_close)
                me.animate_close = params.style.animate_close;
            if(params.style.myclass)
                me.myclass = params.style.myclass;
            if(params.style.show_delay)
                me.show_delay = Math.floor( params.style.show_delay );
            if(params.style.hide_delay)
                me.hide_delay = Math.floor( params.style.hide_delay );
            if(typeof params.style.show_duration !== 'undefined')
                me.show_duration = Math.floor( params.style.show_duration );
            if(params.style.show_distance)
                me.show_distance = Math.floor( params.style.show_distance );
            if(params.style.hide_duration)
                me.hide_duration = Math.floor( params.style.hide_duration );
            if(typeof params.style.hide_distance !== 'undefined')
                me.hide_distance = Math.floor( params.style.hide_distance );
            if(params.style.no_close)
                me.no_close = params.style.no_close;
            if(params.style.node_heap)
                me.node_heap = params.style.node_heap;

        }

        if( params.callbacks ){
            if(params.callbacks.on_open)
                me.on_open_callback = params.callbacks.on_open;
            if(params.callbacks.on_close)
                me.on_close_callback = params.callbacks.on_close;
        }

        me.show =  delayedTooltipShow;
        me.hide =  delayedTooltipHide;
        me.destroy = destroyTooltip;

        me.html = function(html){
            me.wrapper.html(html);
            me.wrapper.append('<div class="arrow"></div>');
            me.arrow = me.wrapper.find('.arrow');
            showTooltip();
        };

        element.tooltip = me;

        return me;
    };

    var destroyTooltip = function(){
        if(me.wrapper)
            me.wrapper.remove();
        element.tooltip = undefined;
        me.already_hidden = true;
        me.is_visible = false;
        clearTimeout( me.hide_timer );
        clearTimeout( me.show_timer );
    };

    var initWrapper = function(){
        me.wrapper = $('<div class="iTooltip"></div>');

        if(me.myclass)
            me.wrapper.addClass(me.myclass);

        if(me.mywidth)
            me.wrapper.css('width', me.mywidth);

        if(me.content_is_func){
            me.content(me);
            return 'need_callback';
        } else
            me.wrapper.html(me.content);

        if(me.wrapper.children().length < 1)
            return false;
        me.wrapper.append('<div class="arrow"></div>');
        me.arrow = me.wrapper.find('.arrow');
    };

    var delayedTooltipShow = function(){
        me.already_hidden = false;
        clearTimeout(me.show_timer);
        clearTimeout(me.hide_timer);
        me.show_timer = setTimeout(function(){ showTooltip(); }, me.show_delay);
        AnyTooltipStack.push(me.element);
        nav2.gc(AnyTooltipGc, 'AnyTooltipGc');
    };
    var showTooltip = function(){
        if(!me.wrapper){
            if(initWrapper() == 'need_callback')
                return true;
        }

        if (me.already_hidden) {
            return false;
        }

        if(!me.is_visible){
            clearTimeout(me.hide_timer);
            me.is_visible = true;
            $(me.node_heap).append(me.wrapper);
            if(!me.no_close){
                me.wrapper.bind('mouseenter', cancelTooltipHide);
                me.wrapper.bind('mouseleave', delayedTooltipHide);
            }

            if(me.animate_open){
                me.animate_open(me);
            } else {
                var elementX = me.element.offset().left + me.element.outerWidth()/2,
                    elementY = me.element.offset().top,
                    finalX = elementX - me.wrapper.outerWidth()/ 10,
                    finalY = elementY - me.wrapper.outerHeight(true),
                    tooltipHeight = me.wrapper.outerHeight(true),
                    wrapperWidth = me.wrapper.outerWidth(true);

                if (finalX + wrapperWidth > fs.windowW) {
                    finalX -= finalX + wrapperWidth - fs.windowW + 10;
                    me.arrow.css('left', elementX - finalX);
                } else {
                    me.arrow.css('left', '');
                }

                if(elementY- fs.scrollTop < tooltipHeight){
                    var elementH = me.element.outerHeight(false);
                    me.arrow.addClass('onTop');
                    me.wrapper.css({left: finalX, top: finalY + tooltipHeight + elementH + 15 + me.show_distance, opacity: 0}).stop()
                        .animate({top: finalY + tooltipHeight + elementH + 15, opacity: 1}, me.show_duration, function(){
                            if(me.on_open_callback)
                                me.on_open_callback(me);
                        });
                } else {
                    me.arrow.removeClass('onTop');
                    me.wrapper.css({left: finalX, top: finalY - 10 - me.show_distance, opacity: 0}).stop()
                        .animate({top: finalY - 10, opacity: 1}, me.show_duration, function(){
                            if(me.on_open_callback)
                                me.on_open_callback(me);
                        });
                }
            }
            return true;
        } else {
            return true;
        }
    };
    var delayedTooltipHide = function(noDelay){
        me.already_hidden = true;
        clearTimeout(me.show_timer);
        clearTimeout(me.hide_timer);
        if(typeof noDelay != 'object' && noDelay)me.hide_timer = setTimeout(hideTooltip,0);
        else me.hide_timer = setTimeout(hideTooltip, me.hide_delay);
    };
    var hideTooltip = function(){
        if(me.is_visible){
            if(me.animate_close){
                me.animate_close(me);
            } else {
                var elementY = me.element.offset().top,
                    wrapperY = me.wrapper.offset().top,
                    finalY = (wrapperY > elementY ? '+=' : '-=') + me.hide_distance + 'px';
                me.wrapper.stop().animate({top: finalY, opacity: 0}, me.hide_duration, function(){
                    if(me.on_close_callback)
                        me.on_close_callback(me);
                    me.wrapper.remove();
                    me.is_visible = false;
                });
            }
        }
    };
    var cancelTooltipHide = function(){
        clearTimeout(me.hide_timer);
    };

    return init(element, config);
}
AnyTooltip.show = function(element, params){
    if(!element.tooltip){
        AnyTooltip(element, params);
    }
    element.tooltip.show();
};
AnyTooltip.hide = function(element){
    if (typeof element.tooltip !== 'undefined') {
        element.tooltip.hide();
        return true;
    } else {
        return false;
    }
};

var userTooltip = {
    cache: {},
    show : function(element, uid, params){
        if (uid == currentUser.userId) return;
        params = $.extend(params,{uid: uid});
        AnyTooltip.show(element, {
            content: {
                func: function(tooltip){
                    if(typeof userTooltip.cache[uid] == 'undefined'){
                        var response = $.get('/tooltip/ajax/getTooltipUser/', params, function(response){
                            userTooltip.cache[uid] = response.ret == 1 ? response.html : '';
                            if (userTooltip.cache[uid].length) {
                                tooltip.html(userTooltip.cache[uid]);
                            } else {
                                tooltip.destroy();
                            }

                        }, 'JSON');
                    } else if (userTooltip.cache[uid].length) {
                        tooltip.html(userTooltip.cache[uid]);
                    } else {
                        tooltip.destroy();
                    }
                }
            },
            style: {
                width: 270,
                myclass: 'user-tooltip',
                show_delay: 200
            }
        });
    },
    hide: function(element){
        AnyTooltip.hide(element);
    }
};

var infoTooltip = {
    show: function (element, content, width, opts) {
        AnyTooltip.show(element, $.extend(true, {
            content: {
                html: '<div class="info-tooltip-content">'+content+'</div>'
            },
            style: {
                myclass: 'info-tooltip',
                width: ( typeof width !== 'undefined' ) ? width : false,
                show_delay: 200,
                show_distance: 15,
                hide_distance: 15,
                animate_open: function (me) {
                    var elementX = me.element.offset().left + me.element.outerWidth()/2,
                        elementY = me.element.offset().top,
                        finalX = elementX - me.wrapper.outerWidth()/2,
                        finalY = elementY - me.wrapper.outerHeight(true),
                        tooltipHeight = me.wrapper.outerHeight(true),
                        wrapperWidth = me.wrapper.outerWidth(true),
                        bodyWidth = $(document.body).width();

                    if (finalX + wrapperWidth > bodyWidth) {
                        finalX = bodyWidth - wrapperWidth-10;
                        me.wrapper.css("width",me.wrapper.width());
                        me.arrow.css('left', elementX - finalX);
                    } else if (finalX < 0) {
                        finalX = 10;
                        me.arrow.css('left', elementX - finalX);
                    } else {
                        me.arrow.css('left', '');
                        me.wrapper.css("width",me.wrapper.width());
                    }

                    if(elementY- fs.scrollTop < tooltipHeight){
                        var elementH = me.element.outerHeight(false);
                        me.arrow.addClass('onTop');
                        me.wrapper.css({left: finalX, top: finalY + tooltipHeight + elementH + 15 + me.show_distance, opacity: 0}).stop()
                            .animate({top: finalY + tooltipHeight + elementH + 15, opacity: 1}, me.show_duration, function(){
                                if(me.on_open_callback)
                                    me.on_open_callback(me);
                            });
                    } else {
                        me.arrow.removeClass('onTop');
                        me.wrapper.css({left: finalX, top: finalY - 10 - me.show_distance, opacity: 0}).stop()
                            .animate({top: finalY - 10, opacity: 1}, me.show_duration, function(){
                                if(me.on_open_callback)
                                    me.on_open_callback(me);
                            });
                    }
                }
            }
        }, opts));
    },
    hide: function (element) {
        AnyTooltip.hide(element);
    },
    destroy: function(){AnyTooltipGc();}
};

var helpTooltip = {
    show: function (element, content, fixX, fixY, showDown) {
        AnyTooltip.show(element, {
            content: {
                html: '<div class="info-tooltip-content">'+content+'</div>'
            },
            style: {
                myclass: 'info-tooltip',
                show_delay: 350,
                show_distance: 15,
                hide_distance: 15,
                animate_open: function (me) {
                    var elementX = me.element.offset().left + me.element.outerWidth()/2,
                        elementY = me.element.offset().top,
                        finalX = elementX - me.wrapper.outerWidth()/2 + ((typeof fixX !== 'undefined') ? parseInt(fixX) : 0),
                        finalY = elementY - me.wrapper.outerHeight(true) + ((typeof fixY !== 'undefined') ? parseInt(fixY): 0),
                        tooltipHeight = me.wrapper.outerHeight(true),
                        wrapperWidth = me.wrapper.outerWidth(true);
                    showDown = (typeof(showDown) !== 'undefined') ? showDown : false;
                    if ((finalX + wrapperWidth > fs.windowW)) {
                        finalX -= finalX + wrapperWidth - fs.windowW + 10;
                        me.arrow.css('left', elementX - finalX);
                    } else if (finalX < 0) {
                        finalX = 10;
                        me.arrow.css('left', elementX - finalX);
                    } else {
                        me.arrow.css('left', '');
                    }

                    if(elementY- fs.scrollTop < tooltipHeight || showDown){
                        var elementH = me.element.outerHeight(false);
                        me.arrow.addClass('onTop');
                        me.wrapper.css({left: finalX, top: finalY + tooltipHeight + elementH + 15 + me.show_distance, opacity: 0}).stop()
                            .animate({top: finalY + tooltipHeight + elementH + 15, opacity: 1}, me.show_duration, function(){
                                if(me.on_open_callback)
                                    me.on_open_callback(me);
                            });
                    } else {
                        me.arrow.removeClass('onTop');
                        me.wrapper.css({left: finalX, top: finalY - 10 - me.show_distance, opacity: 0}).stop()
                            .animate({top: finalY - 10, opacity: 1}, me.show_duration, function(){
                                if(me.on_open_callback)
                                    me.on_open_callback(me);
                            });
                    }
                }
            }
        });
    },
    hide: function (element) {
        AnyTooltip.hide(element);
    }
};

var recordTooltip = {
  cache: {},
  show : function(element, recordId, params){
    params = $.extend(params,{recordId: recordId, ajax: true});
    AnyTooltip.show(element, {
      content: {
        func: function(tooltip){
          var localContent = $('#notify-content-'+recordId);
          if (localContent.length) {
            tooltip.html(localContent.html());
          } else {
            if(!recordTooltip.cache[recordId]){
              var response = $.get('/newsfeed/ajax/gettooltip/', params, function(response){
                recordTooltip.cache[recordId] = response.ret == 1 ? response.html : fsLang.get('newsfeed_deleted_record');
                tooltip.html(recordTooltip.cache[recordId]);
              }, 'JSON');
            } else {
              tooltip.html(recordTooltip.cache[recordId]);
            }
          }
        }
      },
      style: {
        width: 340,
        myclass: 'superTooltip',
        show_delay: 200
      }
    });
  },
  hide: function(element){
    AnyTooltip.hide(element);
  }
};

var iPopupOnEscClose = function(event){
    if(event.keyCode == 27)
        iPopup.close();
};

function AnyPopup(uname, config){
    var content_is_func = false,
        animate_open = false,
        is_visible = false,
        content = false,
        me = {};

    var init = function(uname, params){
        me.mywidth = 800;
        me.on_open_callback = false;
        me.on_close_callback = false;
        me.wrapper = false;
        me.top_offset = false;
        me.uname = uname;
        me.closeAttr = 'onclick="'+me.uname+'.close();"';
        me.overlayClose = 'onclick="var target = event.target || event.srcElement, currentTarget = event.currentTarget || this; if (target == currentTarget) { '+me.uname+'.close(); }"';
        me.noOverlay = '';
        me.myclass = false;
        me.noFormatting = false;
        me.uid = '';

        /* load params */
        if( params.content ){
            if(params.content.html)
                content = params.content.html;
            else if(params.content.func){
                content_is_func = true;
                content = params.content.func;
            }
            else return false;
        } else return false;

        if(typeof params.eventer !== 'undefined'){
            me.eventer = params.eventer;
        }

        if( params.style ){
            if(params.style.width)
                me.mywidth = params.style.width;
            if(params.style.myclass)
                me.myclass = params.style.myclass;
            if(params.style.top_offset)
                me.top_offset = Math.floor( params.style.top_offset );
        }

        if(params.onopen)
            me.on_open_callback = params.onopen;
        if(params.onclose)
            me.on_close_callback = params.onclose;

        if(params.title)
            me.title = params.title;
        if(params.footer)
            me.footer = params.footer;
        if(params.noOverlayClose)
            me.overlayClose = '';
        if(params.noOverlay)
            me.noOverlay = ' noOverlay';
        if(params.noFormatting)
            me.noFormatting = true;

        if(params.uid)
            me.uid = params.uid;

        me.html = function(html){
            me.inner.html(html);
            openPopup();
        };
        me.open = openPopup;
        me.close = closePopup;
        me.align = alignPopup;
        me.isVisible = function(){
            return is_visible;
        };

        scrollable({
            name: me.uname+me.uid,
            onpop: function(){},
            onpush: function(){},
            onbelow: function(){
                me.wrapper.addClass('fixed'+((me.noOverlay)?'':' noOverlay')).css({top: -fs.scrollTop, 'z-index': 1001});
                me.popupBody.css({'z-index': 1000});
                $(window).unbind('keydown.'+me.uname+me.uid, iPopupOnEscClose);
            },
            onover: function(){
                me.wrapper.removeClass('fixed'+((me.noOverlay)?'':' noOverlay'));
                var top = me.wrapper.css('top');
                me.wrapper.css({top: 0, 'z-index': 1009});
                me.popupBody.css({'z-index': 1010});
                scrollToY(-parseInt(top));
                $(window).bind('keydown.'+me.uname+me.uid, iPopupOnEscClose);
            }
        });

        return me;
    };

    var initWrapper = function(){
        me.wrapper = $('<div class="iPopup-overlay'+me.noOverlay+'" id="'+me.uname+me.uid+'" ' +me.overlayClose +'><div class="iPopup">'+
            '<div class="popup-content">'+
            '</div>'+
            '</div></div>');

        me.popupBody = me.wrapper.find('.iPopup');
        if(me.title){
            me.popupBody.prepend($('<div class="popup-header nclear">'+
                    '<h2>'+me.title+'</h2>'+
                    '<i class="icn icn-light-gray icn-cross" '+me.closeAttr+'></i>'+
                '</div>'));
        }
        if(me.footer){
            me.popupBody.append($('<div class="popup-footer nclear">'+
                    me.footer+
                '</div>'));
        }
        if(!me.noFormatting)
            me.inner = me.wrapper.find('.popup-content');
        else
            me.inner = me.wrapper.find('.iPopup');

        if(me.myclass)
            me.wrapper.addClass(me.myclass);

        if(me.mywidth)
            me.popupBody.css('width', me.mywidth);

        if(content_is_func){
            if(content(me)) {
                return 'need_callback';
            } else {
                closePopup();
                return false;
            }
        } else {
            me.inner.html(content);
        }

        if(me.inner.children().length < 1)
            return false;

    };

    var openPopup = function(){
        if(!me.wrapper){
            if(initWrapper() == 'need_callback')
                return true;
        }

        if(!is_visible){
            is_visible = true;
            $('#node-heap').append(me.wrapper);
            scrollable.push(me.uname+me.uid);

            $(window).bind('keydown.'+me.uname+me.uid, iPopupOnEscClose);
            nav2.gc(function(){ $(window).unbind('keydown', iPopupOnEscClose); }, 'closePopup');

            var finalY = 50;
            if(me.top_offset)
                finalY = me.top_offset;
            else if ( fs.windowH - me.popupBody.outerHeight() > 50 )
                finalY = (fs.windowH - me.popupBody.outerHeight())/2;

            me.popupBody.css({'margin-top': finalY});
            if(me.on_open_callback)
                me.on_open_callback(me);

            return true;
        } else {
            return true;
        }
    };

    var alignPopup = function(){
        var finalY = 50;
        if(me.top_offset)
            finalY = me.top_offset;
        else if ( fs.windowH - me.popupBody.outerHeight() > 50 )
            finalY = (fs.windowH - me.popupBody.outerHeight())/2;

        me.popupBody.css({'margin-top': finalY});
    };

    var closePopup = function(){
        if(is_visible){
            $(window).unbind('keydown.'+me.uname+me.uid, iPopupOnEscClose);
            if(me.on_close_callback)
                me.on_close_callback(me);
            if(me.wrapper)
                me.wrapper.remove();
            scrollable.pop(me.uname+me.uid);
            is_visible = false;
            me.eventer.emit('closed', {uid: me.uid, name: me.uname});
        }
    };

    return init(uname, config);
}

var iPopup = {
    eventer: new Eventer({eventPrefix: 'iPopup_'}),
    popup: false,
    popupStack: [],
    config: {},
    init: function(){
        iPopup.eventer.on('closed', function(event, data){
            if(typeof data.uid !== 'undefined'){
                var prevPopup = iPopup.popup;
                if(iPopup.popup.uid === data.uid){
                    prevPopup = iPopup.popup
                    if(iPopup.popupStack.length > 0){
                        iPopup.popup = iPopup.popupStack[iPopup.popupStack.length - 1];
                        iPopup.popupStack.pop();
                        $.extend(iPopup.config, { uid: iPopup.popupStack.length });
                    } else {
                        iPopup.popup = false;
                    }
                } else {
                    var stack = iPopup.popupStack;
                    for(var i = stack.length-1; i>=0; i--){
                        if(stack[i].uid === data.uid){
                            stack.splice(i, 1);
                            $.extend(iPopup.config, { uid: iPopup.popupStack.length });
                            break;
                        }
                    }
                }
            } else {
                return false;
            }
        });
    },
    open: function(text, params){
        if(typeof text === 'undefined' || text == false)
            return false;
        iPopup.config = $.extend({
            content: { html: text },
            eventer: iPopup.eventer
        }, params);
        if(iPopup.popup && iPopup.popup.isVisible() && !params.uid){
            iPopup.popupStack.push(iPopup.popup);
            $.extend(iPopup.config, { uid: iPopup.popupStack.length });
        }
        iPopup.popup = AnyPopup('iPopup', iPopup.config);
        iPopup.popup.open();
        nav2.gc(iPopup.closeAll, 'closeAllPopups');
        return iPopup.popup;
    },
    close: function(){
        if(typeof iPopup.popup.close === 'function'){
            iPopup.popup.close();
        }
    },
    closeAll: function(){
        while ( iPopup.popup !== false )
            iPopup.close();
    },
    align: function(text, popupConfig){
        iPopup.popup.align();
    },
    error: function(text, popupConfig){
        var errorConfig = $.extend(true, {
            title:'Ошибка!',
            style:{width: 500, myclass: 'font-large'}
        }, popupConfig);
        return iPopup.open(text, errorConfig);
    },
    alert: function(text, popupConfig){
        var alertConfig = $.extend(true, {
            title:'Внимание!',
            style:{width: 500, myclass: 'font-large'}
        }, popupConfig);
        return iPopup.open(text, alertConfig);
    },
    confirm: function (text, buttonConfig, popupConfig) {
        buttonConfig = $.extend(true, [{
            title: 'Да',
            myclass: 'ibtn-blue',
            defaultEnter: true
        }, {
            title: 'Нет'
        }], buttonConfig);

        var footer = '',
            currConfig,
            defaultEnterIdx = null;
        for (var i = 0, l = buttonConfig.length; i < l; i++) {
            currConfig = buttonConfig[i];
            footer += '<div class="ibtn unselectable '+(currConfig.myclass ? currConfig.myclass : '')+'">'+currConfig.title+'</div>';
            if (currConfig.defaultEnter) {
                defaultEnterIdx = i;
            }
        }

        var keyDownFn = function (event) {
            if (event.which == 13) { // Enter
                sp(event);
                pd(event);
                iPopup.popup.popupBody.find('.popup-footer .ibtn').eq(defaultEnterIdx).click();
            }
        };
        if (defaultEnterIdx !== null) {
            $(window).bind('keydown', keyDownFn);
            nav2.gc(function(){ $(window).unbind('keydown', keyDownFn); });
        }

        var confirmConfig = $.extend(true, {
            title:'Подтверждение',
            footer: footer,
            style:{width: 500, myclass: 'font-large'}
        }, popupConfig);
        confirmConfig.onopen = function (me) {
            me.popupBody.find('.popup-footer .ibtn').each(function (index, item) {
                item.onclick = function () {
                    var currConfig = buttonConfig[index];
                    if (currConfig.callback) {
                        currConfig.callback(me);
                    }
                    if (!currConfig.preventClose) {
                        iPopup.close();
                    }
                };
            });

            if (popupConfig && popupConfig.onopen) popupConfig.onopen(me);
        };
        confirmConfig.onclose = function (me) {
            $(window).unbind('keydown', keyDownFn);

            if (popupConfig && popupConfig.onclose) popupConfig.onclose(me);
        };
        return iPopup.open(text, confirmConfig);
    },
    anyOpened: function(){ return iPopup.popup ? true : false; }
};
iPopup.init();

var sendMessagePopup = function(userid, params){
    _ajax.get('/friends/ajax/openPopupSendOneMesseng/', {id: userid, param:params}, function(h, s, d){
        if (!d.errors) {
            if(d.error == 0) {
                if (d.popularContact) {
                    iPopup.open (d.html, { title: 'Отправить сообщение', style: {width: 600}, noFormatting: true });
                } else {
                    if (d.redirectToContactAdvQuest) {
                        nav2.go('/usercontact/?qoid=' + userid + '&adventuresQuest=' + d.redirectToContactAdvQuest);
                    }

                     if (d.redirectToContact > 0) {
                        nav2.go('/usercontact/?qoid=' + userid);
                    } else {
                        iPopup.open( d.html, {
                            title: 'Отправить сообщение',
                            style: {width: 575, myclass: 'font-large'} ,
                            onclose: function(){
                                if(typeof SendMessagePopupTimer !== 'undefined')
                                    clearInterval(SendMessagePopupTimer);
                                if(typeof usercontact === 'object' && typeof usercontact.assistant === 'object'
                                  && typeof usercontact.assistant.gc === 'function'){
                                    usercontact.assistant.gc();
                                }
                            }
                        });
                    }
                }
            } else {
                iPopup.open( '<h3>Упс, что-то сломалось</h3>', { title: 'Ошибка', style: {width: 575, myclass: 'font-large'} } );
            }
        } else {
            if (d.errors.what == 'photo') {
                userpic.showUploadPopupNewFs2(23, function(){location.reload(true);});
            } else if (d.errors.what == 'notapprovedphoto') {
                fs.notify('Увы, но вы не можете отправлять сообщения другим пользователям,<br/>пока вашу аватарку не проверят модераторы (это занимает около 2 минут).', {duration: 2000});
            } else if (d.errors.what == 'privacy') {
              fs.notify('Увы, но вы не можете отправить сообщение этому пользователю,<br/>потому что он ограничил входящие сообщения настройками приватности.', {duration: 2000});
            } else if (d.errors.what == 'ignor') {
              iPopup.confirm(d.errors.text, $.extend(true, [{
                title: 'Отмена',
                defaultEnter: true,
                myclass: ''
              }, {
                title: 'Убрать и продолжить',
                myclass: 'ibtn-blue',
                callback: function() {
                  delFromBlacklist(userid, null, function(){
                    $('#profile-blacklist-add').removeClass('d-n');
                    $('#profile-blacklist-del').addClass('d-n');
                    sendMessagePopup(userid, params);
                  });
                }
              }]));

            } else {
                showMailPhoneReminderPopup(9);
            }
            return false;
        }
    });
};

var showGuestPopup = function (hash, title, params) {
    if (params.groupDef) {
        return pacman.showSympathyPopup(params.groupDef, title);
    }
    return notifyPopup.show('guest', hash, title, params);
};

var showPeoplePopup = function (ids, title, params) {
    return notifyPopup.show('people', ids, title, params);
};

var showSympathyPopup = function (ids, title, params) {
    if (params.groupDef) {
        return pacman.showSympathyPopup(params.groupDef, title);
    }
    return notifyPopup.show('sympathy', ids, title, params);
};

var notifyPopup = {
    // Параметры нотификаций: иконки, ширина
    notifications: {
        people   : { width: 544, icon: false },
        guest    : { width: 888, icon: true  },
        sympathy : { width: 888, icon: true  },
        photocontest:{ width: 552, icon: false}
    },
    show: function (popupType, notifyData, title, params, onclose) {
        if (typeof notifyPopup.notifications[popupType] == 'undefined') {
            return false;
        }
        // Настройки текущей нотификации
        var cNotify = notifyPopup.notifications[popupType];
        var ungroup = '';
        if (popupType == "sympathy" && params && params.hasOwnProperty('canGrouped') && params.canGrouped) {
            if (params.hasOwnProperty('notifyId') && params.hasOwnProperty('groupId')) {
                ungroup = '<a class="symphaty-footer-ungroup" onclick="pacman.changeGroup(this, ' + params.notifyId + ', ' + params.groupId + ', 1); sp(event);">Показывать в моих новостях все просмотры моих фото</a>';
            }
        }

        $.post('/pacman/ajax/getNotifyPopup/', { ajax: 1, popupType: popupType, notifyData: notifyData, param: params, page: 1 }, function (response) {
            if(response.ret == 1) {
                var notifyScroll;

                iPopup.open('<ul class="' + popupType + '-list nclear">' + response.html + '</ul>'+(response.hasNext ? '<a class="show-more-link">Показать еще</a>' : ''), {
                    title: (cNotify.icon ? '<div class="' + popupType + '-popup-header-icon"><i class="icn icn-white ' + ((response.icon  != 'undefined') ? response.icon : 'icn-' + popupType) + '"></i></div>' : '') + '' + title,
                    footer: ungroup+'<div class="ibtn ibtn-blue ' + popupType + '-btn-close" onclick="iPopup.close();">Закрыть</div>',
                    style: {
                        myclass: popupType + '-popup',
                        width: cNotify.width
                    },
                    onopen: function (me) {
                        if (response.hasNext) {
                            // Некоторые локальные переменные
                            var loadLock = false,
                                notifyPage = 2,
                                $listContainer = me.popupBody.find('.' + popupType + '-list'),
                                $loader = me.popupBody.find('.show-more-link'),
                                loadPage = function (scroll) {
                                    if(!loadLock) {
                                        loadLock = true;
                                        $.post('/pacman/ajax/getNotifyPopup/', { ajax: 1, popupType: popupType, notifyData: notifyData, param: params, page: notifyPage }, function(response){
                                            if(response.ret == 1){
                                                $listContainer.append(response.html);
                                                notifyPage++;
                                                loadLock = false;
                                            }
                                            if (response.ret != 1 || !response.hasNext) {
                                                scroll.destroy();
                                                $loader.remove();
                                            }
                                        }, 'json');
                                    }
                                };

                            notifyScroll = new Scroller({
                                scrollTo: '.' + popupType + '-popup .show-more-link',
                                onScroll: loadPage
                            });

                            $loader.click(function () {
                                loadPage(notifyScroll);
                            });
                        }
                    },
                    onclose: function () {

                        if (typeof onclose != "undefined") {
                            onclose();
                        }

                        if (notifyScroll) {
                            notifyScroll.destroy();
                        }
                    }
                });
            }
        }, 'json');
    }
};


/*var showAppSettingsPopup = function (appId, queryStr) {
    appSettingsPopup.show(appId, queryStr);
};*/

var appSettingsPopup = {
    // Открыт поап из интересных сервисов?
    fromServices: false,
    queryStr: '',
    appId: '',
    params: {},

    show: function (appId, queryStr, fromSrv, params) {
        // Из интересных сервисов
        appSettingsPopup.queryStr = (typeof queryStr == 'undefined') ? '' : queryStr;
        appSettingsPopup.fromServices = (typeof fromSrv == 'undefined') ? false : true;
        appSettingsPopup.params = (typeof params == 'undefined') ? {} : params;
        appSettingsPopup.appId = appId;
        // Открыть
        $.get('/app/'+appId+'/settings'+appSettingsPopup.queryStr, {}, function (resp) {
            if (!resp) {
                return;
            }
            iPopup.open(resp.content, {
                title: resp.title || 'Настройки сервиса',
                style: { myclass: 'app-settings-popup', width: 550 },
                footer: '<div class="ibtn ibtn-blue app-save-button unselectable" onclick="appSettingsPopup.saveApp(); iPopup.close();">Сохранить</div><div class="ibtn ibtn-border app-close-button unselectable">Закрыть</div><a class="secondary-link app-remove-button">Удалить сервис</a>',
                onopen: function (popup) {
                    popup.popupBody.find('.app-close-button').click(function () {
                        iPopup.close();
                    });
                    popup.popupBody.find('.app-remove-button').click(function () {
                        iPopup.confirm('Вы уверены, что хотите удалить сервис? Все Ваши достижения в нём также будут удалены!', [{
                            callback: function () {
                                appSettingsPopup.removeApp();
                            }
                        }]);
                    });
                }
            });
        }, 'json');
    },
    saveApp: function() {
        if (!appSettingsPopup.fromServices) {
            $('#appSettingsForm').submit();
        } else {
            var postData = $('#appSettingsForm').serialize() + '&isAjax=1&justSave=1'
            // Отправим
            $.post('/app/'+appSettingsPopup.appId+'/rights'+appSettingsPopup.queryStr, postData, function(resp) {
                if (!resp || !resp.ret) {
                    fs.notify(resp.message);
                    return;
                }
            });
        }
    },
    removeApp: function() {
        //TODO:Для интересных сервисов вынести отдельно
        if (appSettingsPopup.fromServices){
            $.post('/app/'+appSettingsPopup.appId+'/remove', { ajax:true, fromServices:true }, function(){
                var params = appSettingsPopup.params;
                if (params) {
                    if ('elem' in params && 'srvAppId' in params && 'srvAppType' in params) {
                        if (typeof interestService != 'undefined') {
                            //interestService.hideService(params.elem, params.srvAppId, { appType: params.srvAppType });
                            // TODO: копипаст удалённого блока из interestService.hideService()
                            var elem = $(params.elem).parents('.int-app');
                            elem.removeClass('int-app tr-bg-color-03 nclear').addClass('int-dummy-app-block dashed-block tr-opacity-03');
                            elem[0].beforeRemoving = elem.html();
                            elem.html('<div class="dashed-block-border"><div class="dashed-block-inner"><span class="dashed-block-big-text trebuchet">Успешно удалено</span><a>Восстановить</a></div></div>');
                            elem.find('a').bind('click', function(){
                                interestService.unHideService(this, params.srvAppId, { appType: params.srvAppType});
                            });
                            // end of копипаст
                        }
                        if (typeof interestsBase != 'undefined') {
                            interestsBase.reloadList();
                        }
                    }
                }
                iPopup.close();
                fs.notify('Сервис удалён');
            });
        } else {
            window.location = '/app/'+appSettingsPopup.appId+'/remove';
        }
    }
};

function SelectText(element) {
  var text = $(element)[0];
  if ($.browser.msie) {
    var range = document.body.createTextRange();
    range.moveToElementText(text);
    range.select();
  } else {
    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(text);
    selection.removeAllRanges();
    selection.addRange(range);
  }
}

function contentEditableBlock(element, config){
    var contentEditableBlock = {},
        contentEditableBlockText = {},
        contentEditableBlockPencil = false,
        contentEditableBlockTimer = 0,
        beforeEditingText = false,
        contentEditableBlockSaveBtn = false,
        contentEditableBlockTimeout = 0,
        defaultText = 'Пусто',
        mottos = false,
        curkey = 0,
        randomMottoBtn = false;

    var init = function(element, params, scope){
        me = scope;
        if(element)
            contentEditableBlock = $(element);
        else
            return false;
        contentEditableBlockText = contentEditableBlock.text();
        if(params.pencil){
            contentEditableBlockPencil = $(params.pencil);
            contentEditableBlockPencil.bind('click.contentEditable', editBlock);
        }
        if(params.mottos){
            mottos = params.mottos;
            if(params.randomBtn){
                randomMottoBtn = $(params.randomBtn);
                randomMottoBtn.bind('click.contentEditable', function(){
                    curkey = curkey < mottos.length - 1 ? curkey+1 : 0;
                    contentEditableBlock.text(mottos[curkey]);
                    onFocusFunction();
                });
            }
        }
        if(params.defaultText)
            defaultText = params.defaultText;

        contentEditableBlock
            .bind('focus.contentEditable', onFocusFunction)
            .bind('blur.contentEditable', onBlurFunction)
            .bind('keydown.contentEditable', onKeydownFunction)
            .bind('paste.contentEditable', function() {
                prepasteFunction();
                setTimeout(postpasteFunction, 2);
            })
            .bind('prepaste.contentEditable', prepasteFunction)
            .bind('postpaste.contentEditable', postpasteFunction);

        me.edit = editBlock;
        element.contentEditableBlock = me;
        return me;
    };

    var editBlock = function() {
        if(!contentEditableBlock.hasClass('active')){
            contentEditableBlock.attr('contenteditable', 'true');
            contentEditableBlock.after('<a id="save-status-btn" class="ibtn ibtn-blue">Сохранить</a>');
            contentEditableBlockSaveBtn = $('#save-status-btn');
            contentEditableBlockSaveBtn.bind('click', updateStatus);
            randomMottoBtn.show();
            contentEditableBlockPencil.hide();
            contentEditableBlock.trigger('focus');
            SelectText(contentEditableBlock);
        }
    };

    var updateStatus = function(){
        var valA = {};
        valA['ajax'] = 1;
        valA['user-motto'] = $.trim(contentEditableBlock.text().replace(/(\r\n|\n|\r)/gm,""));
        valA['section'] = 'motto';
        beforeEditingText = contentEditableBlock.text();
        onBlurFunction(event, [true]);

        $.post('/userinfo/Ajax/saveuserinfo/', valA, function(res){
            if(res.status == 'ok'){
                contentEditableBlock.text(res.message);
                if(res.messageDel == 1){
                    fs.notify('Статус удален');
                } else {
                    if(res.isNew == 1)
                        fs.notify('Статус изменен');
                }
            }
        });
    };

    var onFocusFunction = function() {
        clearTimeout(contentEditableBlockTimeout);
        if(!contentEditableBlock.hasClass('active')) {
            if (!beforeEditingText){
                contentEditableBlockText = contentEditableBlock.text();
                beforeEditingText = contentEditableBlockText;
            } else contentEditableBlock.text(contentEditableBlockText);

            contentEditableBlock.addClass('active');
            contentEditableBlock.parent().addClass('active'); // rewrite
            if(contentEditableBlockText == defaultText)
                contentEditableBlock.text('');
        }
    };
    var onBlurFunction = function(e, reset) {
        clearTimeout(contentEditableBlockTimeout);
        contentEditableBlockTimeout = setTimeout( function(){
            contentEditableBlock.removeClass('active');
            contentEditableBlock.parent().removeClass('active'); // rewrite
            contentEditableBlock.attr('contenteditable', 'false');
            contentEditableBlockText = contentEditableBlock.text();
            contentEditableBlockSaveBtn.remove();
            randomMottoBtn.hide();
            contentEditableBlockPencil.show();
            if(reset){
                beforeEditingText = false;
            } else {
                contentEditableBlock.text(beforeEditingText);
            }
        }, 150);
    };
    var onKeydownFunction = function(event) {
        // ESC=27, Enter=13
        if (event.keyCode == 27) {
            contentEditableBlock.text(contentEditableBlockText);
            onBlurFunction();
        } else if (event.keyCode == 13) {
            updateStatus();
        } else if(contentEditableBlock.text().length >= 250 && $.inArray(event.keyCode, [8,16,17,18,33,34,35,36,37,38,39,40,46]) == -1){
            return false;
        }
    };
    var prepasteFunction = function() {
        contentEditableBlockText = contentEditableBlock.text();
        return true;
    };
    var postpasteFunction = function() {
        if(contentEditableBlock.children().length > 0){
            contentEditableBlockText = contentEditableBlock.text();
            contentEditableBlock.children().remove();
            contentEditableBlock.text(contentEditableBlockText);
        }
        return true;
    };
    this.destroy = function(){
        contentEditableBlock.unbind('.contentEditable');
        randomMottoBtn.unbind('.contentEditable');
        contentEditableBlockPencil.unbind('.contentEditable');
    };

    return init(element, config, this);
}
contentEditableBlock.edit = function(element, event, params){
    if(!element.contentEditableBlock)
        contentEditableBlock(element, params);
    element.contentEditableBlock.edit();
};

/* scrollbar */
function Scrollbar(el, options) {

  var self = this;

  options = self.options = options || {};

  self.wrap = $(ge(el));

  self.inner = self.wrap.children().css({ overflow: ('hidden') });

  self.el = self.inner[0];
  self.content = self.inner.children();

  self.scrollHeight = self.inner.height();
  self.scrollbar = $('<div class="scrollbar-wrap"></div>').css({ right: 0, height: self.scrollHeight });
  self.scrollbar_inner = $('<div class="scrollbar-inner"></div>').appendTo(this.scrollbar);
  self.topShadowDiv = $('<div class="scrollbar-top"></div>');
  self.bottomShadowDiv = $('<div class="scrollbar-bottom"></div>');

  self.wrap.append(self.scrollbar).append(self.topShadowDiv).append(self.bottomShadowDiv);

  self.mouseMove = self._mouseMove.bind(self);
  self.mouseUp = self._mouseUp.bind(self);

  function down(event) {
    if (self.moveY || checkEvent(event)) return;
    $(document).bind('mousemove', self.mouseMove).bind('mouseup', self.mouseUp);
    self.moveY = fs.mouseY - (parseInt(self.scrollbar_inner.css('marginTop')) || 0);

    window.document.body.style.cursor = 'pointer';
    self.scrollbar_inner.addClass('scrollbar-drag');
    cancelEvent(event);
  }

  var wheel = this.wheel.bind(this);

  self.inner.bind('mousewheel DOMMouseScroll', wheel);
  self.scrollbar_inner.bind('mousedown', down);

  // touch
  var touchstart = function(event) {
    event = event.originalEvent;
    self.touchY  = event.touches[0].pageY;
  };
  var touchmove = function(event) {
    event = event.originalEvent;
    var touchY = event.touches[0].pageY;
    self.touchDiff = self.touchY - touchY;
    self.el.scrollTop += self.touchDiff;
    self.touchY = touchY;
    if (self.el.scrollTop > 0 && self.shown !== false) {
      self.update(true);
      cancelEvent(event);
    }
  };
  var touchend = function() {
    self.animateInt = setInterval(function(){
      self.touchDiff = self.touchDiff * 0.9;
      if (self.touchDiff < 1 && self.touchDiff > -1) {
        clearInterval(self.animateInt);
      } else {
        self.el.scrollTop += self.touchDiff;
        self.update(true);
      }
    }, 0);
  };
  self.inner.bind('touchstart', touchstart);
  self.inner.bind('touchmove', touchmove);
  self.inner.bind('touchend', touchend);

  this.inited = true;
  this.update(true);
}

Scrollbar.prototype._mouseMove = function(event) {
  this.el.scrollTop = Math.floor((this.contHeight() - this.scrollHeight) * Math.min(1, (fs.mouseY - this.moveY) / (this.scrollHeight - this.innerHeight)));
  this.update(true);
  return false;
}

Scrollbar.prototype._mouseUp = function(event) {
  this.moveY = false;
  $(document).unbind('mousemove', self.mouseMove).unbind('mouseup', self.mouseUp);
  window.document.body.style.cursor = 'default';
  this.scrollbar_inner.removeClass('scrollbar-drag');
  return false;
}

Scrollbar.prototype.wheel = function(event) {
  if (this.disabled) {
    return;
  }
  event = event.originalEvent;
  var delta = 0;
  if (event.wheelDeltaY || event.wheelDelta) {
    delta = (event.wheelDeltaY || event.wheelDelta) / 2;
  } else if (event.detail) {
    delta = -event.detail * 10
  }
  var stWas = this.el.scrollTop;

  this.el.scrollTop -= delta;

  if (stWas != this.el.scrollTop && this.shown !== false) {
    if (this.options.onWheel) this.options.onWheel();
    this.update(true);
    this.scrollbar_inner.addClass('scrollbar-hovered');
    clearTimeout(this.moveTimeoput);
    this.moveTimeoput = setTimeout((function() {
      this.scrollbar_inner.removeClass('scrollbar-hovered');
    }).bind(this), 300);
  }
  if (this.shown) {
    return false;
  }
}

Scrollbar.prototype.hide = function() {
  this.topShadowDiv.hide();
  this.bottomShadowDiv.hide();
  this.scrollbar.hide();
  this.hidden = true;
}
Scrollbar.prototype.show = function() {
  this.topShadowDiv.show();
  this.bottomShadowDiv.show();
  this.scrollbar.show();
  this.hidden = false;
}
Scrollbar.prototype.disable = function() {
  this.hide();
  this.scrollToY(0);
  this.disabled = true;
}
Scrollbar.prototype.enable = function() {
  this.show();
  this.update();
  this.disabled = false;
}

Scrollbar.prototype.scrollToY = function(top) {
  this.el.scrollTop = parseInt(top);
  this.update(false, true);
}

Scrollbar.prototype.contHeight = function() {
  var self = this;
  if (!self.contentHeight) {
    self.contentHeight = 0;
    self.content.each(function(){
      self.contentHeight += $(this).height();
    });
  }
  return self.contentHeight;
}

Scrollbar.prototype.val = function(value) {
  if (value) {
    this.el.scrollTop = value;
    this.update(true, true);
  }
  return this.el.scrollTop;
}

Scrollbar.prototype.update = function(noChange, updateScroll) {
  if (!this.inited || this.hidden) {
    return;
  }
  if (!noChange) {
    this.contentHeight = false;
    if (this.moveY) {
      return true;
    }
  }
  if (updateScroll) {
    this.scrollHeight = this.inner.height();
    this.scrollbar.css('height', this.scrollHeight);
  }
  var height = this.contHeight();
  if (height <= this.scrollHeight) {
    this.scrollbar_inner.hide();
    this.bottomShadowDiv.hide();
    this.topShadowDiv.hide();
    this.topShadow = this.bottomShadow = false;
    this.shown = false;
    return;
  } else if (!this.shown) {
    this.scrollbar_inner.show();
    this.shown = true;
  }

  var topScroll = this.val();

  var progress = this.lastProgress = Math.min(1, topScroll / (height - this.scrollHeight));

  if (progress > 0 != (this.topShadow ? true : false)) {
    this.topShadowDiv[(this.topShadow ? 'hide' : 'show')]();
    this.topShadow = !this.topShadow;
  }
  if (progress < 1 != (this.bottomShadow ? true : false)) {
    this.bottomShadowDiv[(this.bottomShadow ? 'hide' : 'show')]();
    this.bottomShadow = !this.bottomShadow;
  }

  this.innerHeight = Math.max(40, Math.floor(this.scrollHeight * this.scrollHeight / height));
  this.scrollbar_inner.css({ height: this.innerHeight, marginTop: Math.floor((this.scrollHeight - this.innerHeight) * progress) });

  if (this.options.more && height - this.el.scrollTop < this.scrollHeight * (this.options.offset || 2)) {
    this.options.more();
  }
};

/*  */

var checkbox = function(el, event){
  el = $(el);
  var input = $('input', el);
  if (input.is(':disabled')) return sp(event);
  el.toggleClass('checked');
  input.attr('checked', el.hasClass('checked'));
};

var radiobox = function(el, event){
  var $el = $(el),
      input = $('input', $el);

  if (input.is(':disabled')) return sp(event);

  $('input[name="' + input.attr("name") + '"]').parent().removeClass('checked').find('input').removeAttr("checked");
  input.attr('checked', true).parent().addClass('checked');
};

// Search
var flySearch = function(opts) {
    var self = this;
    self.intervalId = 0;
    self.minLenght = 2;
    self.beforeAjax = null;
    self.onSuccess = null;
    self.onCancel = null;
    self.onError = null;

    self.construct = function() {
        if(!opts.element) {
            console.log('Add selector on element to options');
            return;
        }
        if(!opts.ajaxUrl) {
            console.log('Add URL on ajaxUrl to options');
            return;
        }

        $.extend(self, opts);
        self.wrapper = $(self.element);

        if(self.wrapper.length == 0 || !self.wrapper.is('input')) {
            console.log("Wrapper not found or is not input field, check selector in options");
            return;
        }
        if ($.trim(self.wrapper.val()).length == 0 && !self.wrapper.hasClass('empty')) {
            self.wrapper.addClass('empty');
        }
    };

    self.search = function(params) {
        clearTimeout(self.intervalId);
        var text = $.trim(self.wrapper.val());
        if (text.length < self.minLenght) {
            if (text.length == 0 && !self.wrapper.hasClass('empty')) {
                if (typeof self.onCancel == 'function') {
                    self.onCancel();
                }
                self.wrapper.addClass('empty');
            }
            return;
        }
        self.wrapper.removeClass('empty');
        self.intervalId = setTimeout(function(){
            var ajaxParams = {
                ajax: 1,
                query: text
            };
            if (self.ajaxParams) {
                $.extend(ajaxParams, self.ajaxParams);
            }
            if (params) {
                $.extend(ajaxParams, params);
            }
            if (typeof self.beforeAjax == 'function') {
                self.beforeAjax();
            }
            self.onSearch(ajaxParams);
        }, 350);
    };

    self.onSearch = function (params) {
        $.get(self.ajaxUrl, params, function(res) {
            if (res && res.ret == 1) {
                if (typeof self.onSuccess == 'function') {
                    self.onSuccess(res);
                }
            } else {
                if (typeof self.onError == 'function') {
                    self.onError();
                }
                if (typeof self.onCancel == 'function') {
                    self.onCancel();
                }
            }
        }, 'json');
    };

    self.construct();
};

/**
 fsSelect Module.
 version 1.3
 26.12.2012
 */
var fsSelect = function(opts){
  var self = this;
  self.ajaxLock = false;
  self.disabled = false;
  self.bufferText = "";

  self.construct = function(){
    if(!opts.element) {console.log("Add selector on element to options"); return;}
    if(!opts.array || opts.array.length == 0) {console.log("Array must have minimum 1 element"); return;}

    $.extend(self, opts);
    fsSelect.cache[self.element] = self;
    self.wrapper = $(self.element);
    if(self.wrapper.length == 0) {console.log("Wrapper not found, check selector in options"); return;}

    self.inputValue = $("<input>", {'type': 'hidden', 'name': self.name, 'tabindex': -1});
    self.header = $("<div>", {'class': 'form-select-header tr-bg-color-03'}).append('<i class="form-select-down"></i>');
    self.inputFinder = $("<input>", {
      'class': 'form-select-input',
      'placeholder': self.placeholder ? self.placeholder : ''
    });
    if(self.readonly) self.inputFinder.attr('readonly', 'readonly').addClass('readonly unselectable');
    if(self.tabIndex) {
        self.fakeTab = $('<div>', {'tabindex': self.tabIndex, 'style': 'height:0;width:0;'}).prependTo(self.wrapper);
        self.fakeTab.focus(self.showFinder).blur(function(){ if( self.wrapper.hasClass('opened') ){ fsSelect.hideFinder('close'); } });
    }
    self.header.prepend(self.inputFinder);
    self.wrapper.append(self.header).append(self.inputValue);
    self.update();

    /* events */
    self.inputFinder.bind('keyup', function(event){return _search(event);});
    self.inputFinder.bind('keydown', function(event){return _keyEvent(event);});
    self.inputFinder.bind('focus', function(){self.showFinder();});
    self.inputFinder.click(function(event){

      if(self.readonly){
        if( self.wrapper.hasClass('opened') ){ fsSelect.hideFinder('close'); }
        else { self.showFinder(); }
      } else {
        self.showFinder(); sp(event);
      }

    });
    self.header.click(function(event){
      if(self.wrapper.hasClass('opened')){ fsSelect.hideFinder('close'); }
      else { self.showFinder(); }
    });
  };

  self.change = function(num, fromHide){
    var buffer = self.inputValue.val();
    if(self.array[num][3]) return;

    for(var i in self.array){self.array[i][2] = 0;}
    self.array[num][2] = 1;
    self.update();

    if(self.wrapper.hasClass('opened') && !fromHide) fsSelect.hideFinder('close', true);
    if(typeof(self.onchange) == 'function' && buffer != self.inputValue.val()) self.onchange(self.array[num], self);
  };

  self.disable = function(){self.disabled = true; self.wrapper.addClass('form-select-disabled');self.inputFinder.attr('disabled', 'true');};
  self.undisable = function(){self.disabled = false; self.wrapper.removeClass('form-select-disabled');self.inputFinder.removeAttr('disabled');};

  self.update = function(){
    self.selectedNum = null;

    for(var i in self.array){ if(self.array[i][2]) self.selectedNum = i; }

    if(self.selectedNum || self.selectedNum == 0) {
      self.inputFinder.val(self.array[self.selectedNum][1]);
      self.inputValue.val(self.array[self.selectedNum][0]);
    } else {
      self.inputFinder.val("");
      self.inputValue.val("");
    }
  };

  self.ajaxOn = function(){return self.ajax_url;};
  self.ajaxData = [];
  self.ajax = function(){
    if(self.ajaxLock){return;}

    self.bufferText = self.inputFinder.val();

    var params = {query: self.bufferText};

    if(typeof(self.beforeajax) == 'function') params = self.beforeajax(params, self) ? self.beforeajax(params, self) : params;

    self.ajaxLock = true;

    _ajax.post(self.ajax_url, params, function(html, status, data){
      self.ajaxLock = false;
      if(typeof(self.onajax) == 'function') data = self.onajax(data, self);

      self.ajaxData = data;

      html = self.render(data, true, self.bufferText, true);
      self.finderBox.html(html);

      if(self.bufferText != self.inputFinder.val()){
        self.ajax();
      }
    })
  };

  self.ajaxChange = function(num){
    var addFlag = true;
    for(var i in self.array){
      if(self.array[i][0] == self.ajaxData[num][0]){
        self.change(i);
        addFlag = false;
      }
    }
    if(addFlag){
      self.array.push([self.ajaxData[num][0], self.ajaxData[num][1], self.ajaxData[num][2], self.ajaxData[num][3]]);
      self.change(self.array.length - 1);
    }
  };

  self.showFinder = function(){
    if(fsSelect.current == self.element) {return;}
    if(self.disabled) {return;}
    else {
      $(document)
        .unbind('click', fsSelect.hideFinder)
        .bind('click', fsSelect.hideFinder);
      var offsetPosition = self.wrapper.offset(),
        headerHeight = self.header.outerHeight(),
        headerWidth = self.header.outerWidth();

      fsSelect.current = self.element;
      self.wrapper.addClass('opened');
      self.finderBox = $("#form-selector-box");
      if(self.finderBox.length == 0) self.finderBox = $('<div>', {'id' :'form-selector-box', 'onclick' : "sp(event)"}).appendTo("#node-heap");

      self.finderBox.css({
        'left' : offsetPosition.left,
        'top' : offsetPosition.top + headerHeight - 1,
        'width' : headerWidth - 2,
        'display': 'block',
        'z-index': (self.selectIndex ? self.selectIndex : 2)
      }).html("");

      self.finderBox.attr('class', (self.myclass ? self.myclass : ''));

      var html = self.render(self.array);
      self.finderBox.html(html);
    }
  };

  self.val = function(){return this.inputValue.val(); }

  self.render = function(data, isSearch, text, isAjaxRender){
    var r = "";
    var reSearch = new RegExp('(' + text + ')', 'i')
    for(var i in data){
      if(!data[i][3] && ( (isSearch && (reSearch).test(data[i][1])) || !isSearch ) ){
        r+='<div class="form-selector-item ' +
          ( data[i][2] && !isSearch ? "selected" : "") +
          ( data[i][3] ? "disabled" : "") +
          '" onclick="fsSelect.cache[\'' + self.element + '\'].' + (isAjaxRender ? 'ajaxChange' : 'change' )+ '(' + i + ');">'+
          (isAjaxRender ? (isSearch ? data[i][4].replace(reSearch, "<span class='finded'>$1</span>"): data[i][4]) : (isSearch ? data[i][1].replace(reSearch, "<span class='finded'>$1</span>"): data[i][1])) +
          '</div>';
      }
    }
    if(r.length == 0) {
      r='<div class="form-selector-result">Ничего не найдено</div>';
    } else{
      r=(self.finderTitle ? '<div class="form-selector-result">' + self.finderTitle + '</div>' : '') + r;
    }
    return r;
  };
  self.destroy = function(){
      self.inputFinder.off();
      self.header.off();
      self.wrapper.empty();
      if(fsSelect.cache[self.element]){
          fsSelect.cache[self.element] = null;
          delete fsSelect.cache[self.element];
      }
  };
  self.clear = function () {
    self.inputFinder.val("");
    self.inputValue.val("");
    self.array = [];
  };

  var _search = function(event){
    var inputEl = self.inputFinder,
      inputElVal = inputEl.val(), notSearchKeys = [9, 27, 37, 38, 39, 40];
    if(indexOf(notSearchKeys,event.keyCode) != -1) return;

    if(inputElVal.length == 0) {
      self.finderBox.html(self.render(self.array));
    } else {
      if(self.ajaxOn()){
        self.ajax();
      } else {
        self.finderBox.html(self.render(self.array, true, inputElVal));
      }
    }
  };

  var _keyEvent = function(event){
    var kc = event.keyCode;
    if(kc == 27){
      fsSelect.hideFinder('close');
    } else if(kc == 9){
      fsSelect.hideFinder('close');
    } else if(kc == 13){
      var selectedElement = self.finderBox.find('.selected');
      if(selectedElement){ selectedElement.click();}
      else{fsSelect.hideFinder('close');}
      return false;
    } else if(kc == 38){
      var selectedElement = self.finderBox.find('.selected');
      if(selectedElement){
        selectedElement.removeClass('selected');
        var prev = selectedElement.prev();
        if(prev && prev.hasClass('form-selector-item')){
          prev.addClass('selected');
          if(self.finderBox.find('.selected')[0].offsetTop < self.finderBox[0].scrollTop) {
            self.finderBox[0].scrollTop = self.finderBox.find('.selected')[0].offsetTop;
          }
        } else {
          self.finderBox.find('.form-selector-item:last').addClass('selected');
          self.finderBox[0].scrollTop = self.finderBox.height();
        }
      }
      return false;
    } else if(kc == 40){
      var selectedElement = self.finderBox.find('.selected');
      if(selectedElement){

        selectedElement.removeClass('selected');

        var next = selectedElement.next();
        if(next && next.hasClass('form-selector-item')){
          next.addClass('selected');

          if(self.finderBox.find('.selected')[0].offsetTop + self.finderBox.find('.selected').outerHeight() > self.finderBox.height() + self.finderBox[0].scrollTop) {
            self.finderBox[0].scrollTop = (self.finderBox.find('.selected')[0].offsetTop - self.finderBox.height()+ self.finderBox.find('.selected').outerHeight());
          }
        } else {
          self.finderBox.find('.form-selector-item:first').addClass('selected');
          self.finderBox[0].scrollTop = 0;
        }
      }
      return false;
    }
    sp(event);
  };

  self.construct();
};

fsSelect.cache = {};
fsSelect.current = null;
fsSelect.hideFinder = function(event, force){
  if((typeof(event) != 'string' && $(event.target).closest('.form-select-wrap').length == 0) || event == 'close'){
    $(document).unbind('click', fsSelect.hideFinder);
    var currentSelect = fsSelect.cache[fsSelect.current], flagFinded = false;
    if(!force){
      if(currentSelect.ajaxData.length){
          for(var i in currentSelect.ajaxData){
              var _val = currentSelect.inputFinder.val();
              if((new RegExp(currentSelect.ajaxData[i][1], 'i')).test(_val) && !currentSelect.ajaxData[i][3] && currentSelect.ajaxData[i][1].length == _val.length){
                  currentSelect.array.push(currentSelect.ajaxData[i]);
                  currentSelect.change(currentSelect.array.length - 1, true);
                  flagFinded = true;
              }
          }
      } else {
          for(var i in currentSelect.array){
              if(currentSelect.array[i][1] == currentSelect.inputFinder.val()){
                  currentSelect.change(i, true);
                  flagFinded = true;
              }
          }
      }
    }

    if(!flagFinded){currentSelect.update();}
    currentSelect.inputFinder.blur();
    currentSelect.finderBox.html("").hide();
    $('.form-select-wrap').removeClass('opened');
    fsSelect.current = null;
  }
};

var userLogoutFunction = function(){
    var link = '/user/logout/',
        header = 'Вы уверены, что хотите выйти?',
        confirm = 'Если вы нажмёте &laquo;Да&raquo;, то в следующий раз вам придётся заново вводить логин и пароль.';

        iPopup.confirm(confirm, [{
            callback: function(){
                contextNav.clear();
                location.href = link;
            }
        }],
            { title: header }
        );
    return false;
};

var showConfirmEmailPopup = function(content, callback) {
    if (typeof content != "undefined" && content) {
        iPopup.open(content, {'title': 'Подтвердите ваш e-mail', style: {'width': 450, myclass: 'font-large'} , noOverlayClose:true, onopen: function(){ emp.init(); $('#user_email').focus();},
            onclose: function(){ if(typeof callback != 'undefined') callback(); }});
    } else {
        $.post('/userinfo/ajax/confirmEmailPopup/', {ajax: 1}, function (data) {
            iPopup.open(data, {'title': 'Подтвердите ваш e-mail', style: {'width': 450, myclass: 'font-large'} , noOverlayClose:true, onopen: function(){ emp.init(); $('#user_email').focus();},
                onclose: function(){ if(typeof callback != 'undefined') callback();}});
        });
    }
};

var showConfirmPhonePopup = function(content, callback) {
    if ((typeof content != "undefined") && content) {
        iPopup.open(content, {'title': 'Подтвердите телефон', style: {'width': 630, myclass: 'phone-reminder-popup'} , noOverlayClose:true, onopen: function(){ return true; },
            onclose: function(){ if(typeof callback != 'undefined') callback();}});
    } else {
        $.post('/userinfo/ajax/confirmPhonePopup/', {ajax: 1}, function (data) {
            iPopup.open(data, {'title': 'Подтвердите телефон', style: {'width': 630, myclass: 'phone-reminder-popup'} , noOverlayClose:true, onopen: function(){ return true; },
                onclose: function(){ if(typeof callback != 'undefined') callback();}});
        });
    }
};

var showUploadMainPhotoPopup = function() {
    userpic.showUploadPopupNewFs2(24, function() {location.reload(true);});
};

var showMailPhoneReminderPopup = function(purpose, callback){
    $.post('/profile/reminder/reminder/', { ajax: true, purpose: purpose }, function (res) {
        if(res.type == 'phone')
            showConfirmPhonePopup(res.html);
        else if (res.type == 'email')
            showConfirmEmailPopup(res.html);
    });
};

var selectAgePopup = {
    isIncClose: true,
    save: function () {
        var data = {
            'section': 'user_birthday',
            'source': 'selectAgePopup',
            'birth-day': $('#userinfo-user-birthday input[name=birth-day]').val(),
            'birth-month': $('#userinfo-user-birthmonth input[name=birth-month]').val(),
            'birth-year': $('#userinfo-user-birthyear input[name=birth-year]').val(),
            'privacy-filter': $('.birthday-year-privacy .dropdown-item-title a').data('filter')
        };

        if (data['birth-day'] == '0' || data['birth-month'] == '0' || data['birth-year'] == '0') {
            fs.notify('Укажите корректную дату рождения.');
        } else {
            $.post('/userinfo/ajax/saveuserinfo', data);
            if (!(typeof(currentUser.userAge) == 'undefined')) {
                var d = new Date(),
                    cd = new Date();
                d.setFullYear(data["birth-year"], data["birth-month"]-1, data["birth-day"]);
                currentUser.userAge = Math.floor((cd.getTime()-d.getTime()) / 31556926000);
            }
            this.isIncClose = false;
            iPopup.close();
        }
    },
    open: function () {
        $.post('/userinfo/ajax/selectAgePopup/', function (data) {
            iPopup.open(data.html, {
                title: 'Когда у вас День Рождения?',
                style: {
                    width: 580,
                    myclass: 'select-age-popup-wrapper'
                },
                onopen: function() { return true; },
                onclose: function() {
                    if (!selectAgePopup.isIncClose) {
                        return true;
                    }
                    var mainStat = new _jstat('Main');
                    mainStat.add('select_age_popup_close', 1);
                    mainStat.send();
                    return true;
                },
                footer: '<div style="text-align: center"><span style="margin: 0; float: none;" class="ibtn ibtn-blue ibtn-big" onclick="selectAgePopup.save()">Жду поздравлений!</span></div>'
            });
        });
    }
};

/**
 * Namespace for VIP-related functions
 */
var fs2vip = {
    // Vip2 popup for buing
    popupVipBuying: function(serviceType, bonus, onCancelFnc, forUserId, onBuyVipFnc, refAppId) {
        if (isVip2Available) {
            _ajax.post('/vip2/ajax/getConfig/', {}, function(html, status, data) {
                staticManager.add(data.modules.buying.js, data.modules.buying.css, function () {
                    vip.modules.buying.init({billing: data.billing, user: data.user}, onBuyVipFnc, {serviceType: serviceType});
                    vip.modules.buying.popup.open({
                        render: {
                            buying: {},
                            compare: {
                                modClass: 'h',
                                services: data.services
                            },
                            period: {
                                modClass: 'h'
                            }
                        }
                    });
                });

                $.get('/vip2/ajax/incr/', {field: 'popup_summ_show', eRf: nav2.getParam('eRf')});
            });
            return;
        }

        if (!window.currentUser || !window.currentUser.userId) {
            fs.notify (fsLang.get('login_need'));
            return;
        }
        if (!bonus) bonus = 0;
        if (!forUserId) forUserId = 0;
        onSimpleBuyVipFnc = onBuyVipFnc;

        var onbeforeunloadBinded = false;
        var vipPBuyClickedOnly = false;
        var entrance = 0;
        if (window.entranceMeetingFS12 !== undefined) {
            entrance = fsNow() - window.entranceMeetingFS12 <= 30000 ? 1 : 0;
        }

        if (serviceType == 3 || serviceType == 4 || serviceType == 5 || serviceType == 32 || serviceType == 40 || serviceType == 49 || serviceType == 52 || serviceType == 14) {
            var closeSaveClicked = false;
            if (window.nav2) {
                nav2.gc(function(){
                    $(document).unbind('click.meetingSaveClicked');
                    if (typeof onbeforeunloadBinded != 'undefined' && onbeforeunloadBinded) {
                        window.onbeforeunload = null;
                    }
                });
            }
        }

        _ajax.post('/vip/ajax/popupbuy/', {'ajax':true, entrance: entrance, serviceType:serviceType, bonusBuy:bonus, forUserId:forUserId, refAppId:refAppId}, function (data){
            iPopup.open(data, {title: fsLang.get('vip_account'), style: {width: 760, myclass: 'vip-popup-buyingwrap'}, noOverlayClose: true,
                onopen: function () {
                    if (serviceType == 3 || serviceType == 4 || serviceType == 5 || serviceType == 32 || serviceType == 40 || serviceType == 49 || serviceType == 52 || serviceType == 14) {
                        $('#iPopup .icn-close').attr('onclick', 'event.stopPropagation(); iPopup.close();');
                        $(document).bind('click.meetingSaveClicked', function (e) {
                            vipPBuyClickedOnly = false;
                            if( $(e.target).parents('.vip-p-card-1, .vip-p-card-2, .vip-p-card-3').length ) {
                                $.get('/vip/ajax/saveclosedmeeting/?type=buy');
                                vipPBuyClickedOnly = true;
                            }

                            if( $(e.target).hasClass('vip-p-corner') || $(e.target).parents('.vip-p-corner').length ) {
                                $.get('/vip/ajax/saveclosedmeeting/?type=36month');
                                vipPBuyClickedOnly = true;
                            }

                            if( $(e.target).hasClass('btn-free-vip') || $(e.target).parents('.btn-free-vip').length ) {
                                $.get('/vip/ajax/saveclosedmeeting/?type=freevip');
                                vipPBuyClickedOnly = true;
                            }

                            closeSaveClicked = true;
                        });
                        if (window.onbeforeunload !== null) {
                            window.onbeforeunload = function(){ $('<img>').attr('src', '/vip/ajax/saveclosedmeeting/?type=browser'); };
                            onbeforeunloadBinded = false;
                        }
                    }
                },
                onclose: function (){
                if (typeof vipClub !== 'undefined') {
                    vipClub.sendStat('close');
                }
                if ($.isFunction (onCancelFnc)) onCancelFnc();
                if (serviceType == 3 || serviceType == 4 || serviceType == 5 || serviceType == 32 || serviceType == 40 || serviceType == 49 || serviceType == 52 || serviceType == 14) {
                    if (typeof closeSaveClicked != 'undefined') {
                        if (closeSaveClicked === false) {
                            $.get('/vip/ajax/saveclosedmeeting/?type=popup');
                        }
                        if (vipPBuyClickedOnly) {
                            $.get('/vip/ajax/saveclosedmeeting/?type=closebuy');
                        }
                        $(document).unbind('click.meetingSaveClicked');
                        window.onbeforeunload = null;
                    }
                }
            }});
        });
    },
    popupVip2Buying: function (data, callback, canSelectPeriod) {
        _ajax.post('/vip2/ajax/getConfig/', {}, function(html, status, resp) {
            staticManager.add(resp.modules.buying.js, resp.modules.buying.css, function () {
                vip.modules.buying.init({billing: resp.billing, user: resp.user}, callback, data);

                //если юзер вип (не бесплатный), показываем попап с апгрейдом
                if (currentUser.userVipLevel > 1 && currentUser.userVipLevel != (data && data.vipType)) {
                    vip.modules.buying.upgrade.showProfitPopup((data && data.vipType) ? data.vipType : currentUser.userVipLevel, !!(data && data.vipType), canSelectPeriod);
                    return;
                }

                //если юзер не вип (или бесплатный), показываем попап с покупкой
                vip.modules.buying.popup.open({
                    render: {
                        buying: {
                            modClass: (data && data.hideScreen && data.hideScreen.indexOf('buying') != -1) ? 'h' : ''
                        },
                        compare: {
                            modClass: (data && data.hideScreen && data.hideScreen.indexOf('compare') != -1) ? 'h' : '',
                            services: resp.services
                        },
                        period: {
                            modClass: (data && data.hideScreen && data.hideScreen.indexOf('period') != -1) ? 'h' : ''
                        }
                    }
                });
            });

            var fields = 'popup_summ_show';
            if (data && data.vipType && currentUser.userVipLevel > 1 && currentUser.userVipLevel != data.vipType) {
                var ps = data.purchaseSource ? data.purchaseSource : 0;
                fields = ['popup_summ_show', 'upgrade_shows_' + data.vipType + '_' + ps];
            }
            $.get('/vip2/ajax/incr/', {field: fields, eRf: nav2.getParam('eRf')});
        });
    },
    // Vip popup subscribe
    vipPopupSubscribe: function (pays, notify) {
        var widthPopup = notify ? 600 : 950;
        $.post("/vip/ajax/popupsteps", {ajax: 1, pays: pays, notify:notify}, function(data){
            iPopup.open(data, {title: "Подписка на VIP-статус", style: {width: widthPopup}})
        })
    },
    popupVipInvisiblePromo: function () {
        _ajax.get('/vip/ajax/popuptryinvisible/', {}, function(html){
            iPopup.open(html, {title: 'Режим «Невидимка»', style: {width: 550}});
        });
    },
    setVipInvisibleStatus: function (status) {
        $.post('/vip/ajax/paramguest/', {'ajax': true, status: status}, function() {
            iPopup.close();
        });
    },

    vipEndTodayPopup: function(){
        _ajax.get('/vip2/ajax/vipEndToday/', {}, function (html, status, data) {
            popup = iPopup.open(html, {
                title: data.title,
                //footer: '<span class="ibtn ibtn-blue discount-ibtn" onclick="iPopup.close();">Хорошо</span>',
                style: {
                    myclass: data.css_class,
                    width: 560
                }
            });
        });
    },
    /**
     * Попап покупки випа из других сервисов (при тыке на функционал, требующий випа)
     *
     * Краткий вариант вызова:
     * fs2vip.buyPopup(featureId, opts);
     *
     * Расширенный вызов:
     * fs2vip.buyPopup({
     *     featureId: featureId,
     *     vipLevel: vipLevel,
     *     vipPeriod: vipPeriod,
     *     purchaseSource: purchaseSource,
     *     serviceType: serviceType,
     *     ... // любые кастомные поля, которые будут как-то по-особому обрабатываться на бекенде
     * }, opts);
     *
     * Все параметры опциональны.
     *
     * opts: {
     *     callback: function () {} // коллбек, вызываемый по завершению покупки випа
     * }
     */
    buyPopup: {
        popup: null,
        selects: null,
        level: 0,
        period: 0,
        opts: null,
        data: null,
        open: function (data, opts, params) {
            var _this = this;
            if (typeof data != 'object') {
                data = {
                    featureId: data
                }
            }
            this.opts = opts || {};
            this.params = params || {};

            _ajax.get('/vip2/ajax/buyPopup/', $.extend({ eRf: nav2.getParam('eRf') }, data), function (html, status, data) {
                $.extend(_this.params, data.fsBuyParams);
                _this.popup = iPopup.open(html, {
                    title: data.title,
                    style: {
                        myclass: data.css_class,
                        width: 630
                    },
                    onopen: function (popup) {
                        if (data.vipConfig && data.vipConfig.length > 1) {
                            _this.createSelects(data, popup);
                        }
                        $.extend(_this.data, data);

                        nav2.gc(function () {
                            for (var select in _this.selects) {
                                _this.selects[select].destroy();
                            }
                            _this.selects = null;
                        }, 'vipBuyPopup');
                    },
                    onclose: function () {
                        _this.popup = null;
                        _this.opts = null;
                    }
                });
            });
        },
        init: function (data) {
            var _this = this;
            this.data = data;
            if (this.data.reload && !this.opts.callback) {
                this.opts.callback = function () {
                    document.location = typeof _this.data.reload == 'string' ? _this.data.reload : document.location;
                };
            }
        },
        createSelects: function (data, popup) {
            if (!data || !data.vipConfig) return;

            var _this = this;

            this.selects = {};
            for (var level_i = 0, level_l = data.vipConfig.length, level, selectArray; level_i < level_l; ++level_i) {
                level = data.vipConfig[level_i];
                selectArray = [];
                for (var period_i = 0, period_l = level.periods.length, period, isSelected; period_i < period_l; ++period_i) {
                    period = level.periods[period_i];
                    isSelected = period_i == 0 && period.period > data.vipSelectedPeriod || period.period == data.vipSelectedPeriod;
                    selectArray.push([period.period, period.title + ' - ' + period.price + ' ФМ', isSelected, 0]);
                }
                if ($('#vip-buy-level-' + level.level + '-period').length) {
                    this.selects[level.level] = new fsSelect({
                        element: '#vip-buy-level-' + level.level + '-period',
                        name: "vip-period",
                        readonly: true,
                        array: selectArray,
                        selectIndex: Math.floor(popup.wrapper.css('z-index'))+1
                    });
                }
            }
        },
        nextStep: function () {
            if (this.popup) this.popup.inner.find('.vip-buy-step.active').removeClass('active').next().addClass('active');
        },
        getPeriod: function (level) {
            if (this.data.vipConfig.length > 1) { // У нас несколько випов на выбор
                return this.selects[level].val();
            } else {
                return this.data.period;
            }
        },
        setPeriod: function (period) {
            this.data.period = period;
        },
        buyClick: function (level, period, params) {
            // инициализируем модуль покупки непосредственно перед самой покупкой, чтобы быть уверенными, что никакой другой попап не успел переинитить его.
            vip.modules.buying.init(null, this.opts.callback, {
                purchaseSource: this.data.purchaseSource,
                serviceType: this.data.serviceType
            });

            level = level || this.data.level;
            period = period || this.data.period;

            vip.modules.buying.buy($.extend({}, this.params, params, {
                type: level,
                subtype: period
            }));
        }
    },
    showComparePopup: function() {
        _ajax.get('/vip2/ajax/comparePopup/', {}, function (html, status, data) {
            vip.modules.buying.init(data);
            vip.modules.buying.popup.open({
                render: {
                    buying: {
                        modClass: 'h'
                    },
                    compare: {
                        modClass: 'vip-m-only-compare',
                        services: data.services
                    },
                    period: {
                        modClass: 'h'
                    }
                }
            });
        }, 'json');
    },
    freeVipPopup: function () {
        _ajax.post('/invites/vip/vipactpopup/', {ajax: 1, toOwnPopup: 1, serviceType: 1},
            function (html, status, resp) {
                if (typeof(html) != "undefined" && html) {
                    iPopup.open(html,
                        {
                            title: 'VIP-статус бесплатно',
                            style: {width: 550, myclass: 'meeting-p-blue'},
                            onopen: function () {
                                vipForInvitesPopup.socBtnsInit();
                                actInvite.init();
                                actInvite.checkAllChecks();
                            },
                            onclose: function () {
                                actInvite.pSt(actInvite.closeType);
                            }
                        }
                    );
                }
            }
        );
    }
};
// Aliases for deprecated calls.
var popupVipBuying = function () {
    // Not deprecated yet because old calls are not replaced by new ones
    fs2vip.popupVipBuying.apply(fs2vip, arguments);
};
var popupVip2Buying = function () {
    if(typeof customJsLog === 'function'){ customJsLog('popupVip2Buying deprecated call'); }
    fs2vip.popupVip2Buying.apply(fs2vip, arguments);
};
var vipPopupSubscribe = function () {
    if(typeof customJsLog === 'function'){ customJsLog('vipPopupSubscribe deprecated call'); }
    fs2vip.vipPopupSubscribe.apply(fs2vip, arguments);
};
var popupVipInvisiblePromo = function () {
    if(typeof customJsLog === 'function'){ customJsLog('popupVipInvisiblePromo deprecated call'); }
    fs2vip.popupVipInvisiblePromo.apply(fs2vip, arguments);
};
var setVipInvisibleStatus = function () {
    if(typeof customJsLog === 'function'){ customJsLog('setVipInvisibleStatus deprecated call'); }
    fs2vip.setVipInvisibleStatus.apply(fs2vip, arguments);
};

/**
 * user age popup
 */

var userageFs2 = {
    ok: null,
    cancel: null,
    showSetAgePopup: function(reasonId, callbackOk, callbackCancel){
        userage.ok = callbackOk;
        $.post("/userinfo/ajax/setAgePopup",{ajax:true,reasonId:reasonId},function(data){
            iPopup.open(data,{title:'Укажите возраст', style: {width:545, myclass: 'useragepopup'},footer: '<span class="ibtn ibtn-blue" onclick="saveBirthDay()">Сохранить</span>', onclose:function(){userage.closePopup(callbackCancel)}});
        });
    },
    closePopup: function(c){ if ($.isFunction(c)) c(); }
};

var showUploadPhotoPopup = function (albumId, reason, custom, callback, source, field) {
    if($('body').hasClass('fs-1')){
        window.open( '/user/'+currentUser.userId+'/?uploadPhoto=1', '_blank');
        return true;
    }
    var userId = 0;
    var galleryId = 0;
    var imageId = 0;

    if (custom) {
        userId = custom.userId ? custom.userId : 0;
        galleryId = custom.galleryId ? custom.galleryId : 0;
        imageId = custom.imageId ? custom.imageId : 0;
    }

    _ajax.get('/userphoto/ajax/uploadphotopopup/', {albumId: albumId, reason:reason, galleryId: galleryId, userId: userId, imageId: imageId, source: source, field: field}, function(html, status, data) {
        if (status === 'ok') {
            if (!albumId) {
                title = 'Загрузка личных фотографий';
            } else {
                title = 'Загрузка фотографий';
            }

            var a = $(html);
            iPopup.open(a.slice(0, 1).html(), { title: title, style: {width: 500}, onopen: function () {
                $('.iPopup:last').append(a.slice(1));
                var offset = parseInt($('#popupWin').css('top'));
                var offsetY = offset + 150;
                if(typeof callback != 'undefined') {
                    callback();
                }
            }, onclose: function(){
                $('#button-go-photo-album:visible *').click();
                if(typeof clickStat != 'undefined')
                    clickStat('closechild');
            } });
        } else {
            if (status === 'no_phone') {
                showConfirmPhonePopup();
            } else if (status === 'no_email') {
                showConfirmEmailPopup();
            } else if (status === 'is_banned') {
                popup.simple('<h4>Вы сможете загрузить фотографии после окончания блокировки Вашего профиля.</h4>');
            } else if (status === 'select_album') {
                userpic.selectPersonalAlbum();
            } else if (status === 'no_album') {

            } else if (status === 'no_main_photo') {
                // 50 = FIELD_UPLOADER_SOURCE_AVATAR_NEW
                userpic.showUploadPopupNewFs2(21, function () { location.reload(true) }, function() {}, 0, 50);
            }
        }
    });
};

var showUploadPhotoPopupWithSource = function (field, albumId, reason, custom, callback, source) {
    showUploadPhotoPopup(albumId, reason, custom, callback, source, field);
};


/* complaint */

var complaintPopup = {
    add: function(type, id, data, reason, email) {
        email = typeof email != 'undefined' ? email : '';
        $.post('/support/complaint/add/', { ajax: true, type: type, id: id, data: data, reason: reason, email: email }, function(response) {
            if (parseInt(response.accepted)) {
                fs.notify('Твоя жалоба принята к рассмотрению');
            }
        });
    },

    showForm: function(type, id, data) {
        $.post('/support/complaint/popup/', { ajax: true, type: type, id: id, data: unescape(data) }, function(response) {
            if (response.html) {
                iPopup.open(response.html, {
                    title: response.title,
                    footer: '<a href="/security/?from=context" target="_blank">Сделаем Фотострану безопаснее вместе</a>',
                    noOverlayClose: true,
                    noOverlay: false,
                    noFormatting: false,
                    style: {
                        width: 700,
                        top_offset: false
                    }
                });
            }
        });
    }
};

/**
 * Right Tabs (31.10.2012)
 *
 * @param element кнопка открытия/закрытия блока с содержимым
 * @param contentBlock блок для вывода содержимого
 */
var rightTabDropMenu = {
    currConfig: null,
    click: function(element, event, config){
        rightTabDropMenu.toggle(element, config);
        sp(event);
    },
    open: function (element, config) {
        rightTabDropMenu.closeAll();

        rightTabDropMenu.currConfig = config;

        element = $(element);
        element.addClass('on');
        element.find('.tab-content-wrap').stop(true).show().css('opacity', 0).fadeTo(300, 1);

        $(document).bind('click', rightTabDropMenu.closeAll);

        if (rightTabDropMenu.currConfig && typeof rightTabDropMenu.currConfig.onOpen == 'function') {
            rightTabDropMenu.currConfig.onOpen();
        }
    },
    close: function (element) {
        if (element) {
            element = $(element);
            element.removeClass('on');
            element.find('.tab-content-wrap').stop(true).fadeTo(200, 0, function () { $(this).hide(); });
        }

        $(document).unbind('click', rightTabDropMenu.closeAll);

        if (rightTabDropMenu.currConfig && typeof rightTabDropMenu.currConfig.onClose == 'function') {
            rightTabDropMenu.currConfig.onClose();
        }

        rightTabDropMenu.currConfig = null;
    },
    closeAll: function () {
        rightTabDropMenu.close();

        $('#setting-tabs .tab-name').removeClass('on');
        $('#setting-tabs .tab-content-wrap').stop(true).fadeOut(200);
    },
    toggle: function (element, config) {
        if(rightTabDropMenu.isOpened(element)) {
            rightTabDropMenu.close(element);
        } else {
            rightTabDropMenu.open(element, config);
        }
    },
    isOpened: function (element) {
        return $(element).hasClass('on');
    },
    setContent: function (tab, content) {
        var container = $('.tab-content', element);
        container.children().not('.fs-ie-pseudo').remove();
    },



    /**
     * Новости друзей. Импорт новостей из ВК  (31.10.2012)
     */
    loadNewsfeedVk: function (tab, event){
        rightTabDropMenu.click(tab, event, {
            onOpen: function () {
                newsfeed.vkImport.vkImportPopupFs2('newsfeed', $('.tab-content', tab));
            },
            onClose: function () {
              $('.tab-content', tab).html('');
            }
        });
    },

    /**
     * Новости друзей. Настройки  (31.10.2012)
     */
    loadNewsfeedSettings: function(tab,event,type){
        rightTabDropMenu.click(tab, event, {
            onOpen: function () {
                $.get("/newsfeed/ajax/settingsDialog/",{ajax:1, type:type}, function(settingsHTML) {
                    $('.tab-content', tab).html(settingsHTML);
                });
            }
        });
    },

    /**
     * Лучшие фотографии. Настройки  (31.10.2012)
     */
    loadPhototopSettings:function(tab,event,type){
        rightTabDropMenu.click(tab, event, {
            onOpen: function () {
                $.get("/newsfeed/ajax/settingsDialog/",{ajax:1, type:type}, function(settingsHTML) {
                    $('.tab-content', tab).html(settingsHTML);
                });
            }
        });
    },

    /**
     * Пакмен. Настройки  (31.10.2012)
     */
    loadPacmanSettings:function(tab, event){
        rightTabDropMenu.click(tab, event, {
            onOpen: function () {
                var content = $('.tab-content', tab);
                content.html('<div class="tab-preloader"><i class="icn icn-process"></i></div>');
                $.get("/pacman/ajax/appsSettings/",{ ajax: 1 }, function(settingsHTML) {
                    content.html(settingsHTML.content);
                });
            }
        });
    }
};

(function (dragndrop) {
    var startOffset = 5,
        classAdded,
        started = false,
        startX, startY,
        dx, dy,
        dropTargetSelector,
        dropTarget, dropTargetPos, dropTargetW, dropTargetH,
        element, elementPos, elementW, elementH,
        maxW, maxH,
        dropCallbackFn;

    var checkDrag = function (e) {
        if (started || Math.abs(e.clientX - startX) > startOffset || Math.abs(e.clientY - startY) > startOffset) {
            if (!started) {
                startDrag();
            }
            elementPos = {
                left: e.pageX - dx,
                top: e.pageY - dy
            };
            element.offset(elementPos);
            if (intersects()) {
                dropTarget.addClass('dragndrop-target-active');
            } else {
                dropTarget.removeClass('dragndrop-target-active');
            }
        }
    }, startDrag = function () {
        started = true;

        element = $(element);

        var startPos = element.offset();
        dx = startX - startPos.left;
        dy = startY - startPos.top;
        dropTarget = $(dropTargetSelector);
        dropTargetPos = dropTarget.offset();
        dropTargetW = dropTarget.width()/2;
        dropTargetH = dropTarget.height()/2;
        elementW = element.width()/2;
        elementH = element.height()/2;
        maxW = elementW + dropTargetW;
        maxH = elementH + dropTargetH;

        element.addClass('dragndrop-elem-dragging');
        if (!element.hasClass('unselectable')) {
            element.addClass('unselectable');
            classAdded = true;
        }
        element.bind('click.dragndrop', function (e) {
            pd(e);
            sp(e);
        });

        $('body').css('cursor', 'move');
    }, intersects = function () {
        var x1 = elementPos.left + elementW,
            y1 = elementPos.top + elementH,
            x2 = dropTargetPos.left + dropTargetW,
            y2 = dropTargetPos.top + dropTargetH;

        if (Math.abs(y1 - y2) < maxH) {
            return Math.abs(x1 - x2) < maxW;
        }
        return false;
    }, deselectText = function () {
        if (document.selection) {
            document.selection.empty();
        } else if (document.getSelection) {
            document.getSelection().removeAllRanges();
        }
    };

    dragndrop.start = function(elem, event, dropSelector, dropCallback) {
        dragndrop.stop();
        deselectText();
        pd(event);
        sp(event);

        element = elem;
        startX = event.pageX;
        startY = event.pageY;
        dropTargetSelector = dropSelector;
        dropCallbackFn = dropCallback;

        $('body').addClass('unselectable');

        $(document).bind('mousemove.dragndrop', function (e) {
            checkDrag(e);
        }).bind('mouseup.dragndrop', function (e) {
            dragndrop.stop();
        });
    };
    dragndrop.stop = function() {
        $(document).unbind('.dragndrop');
        $('body').removeClass('unselectable');

        if (started) {
            $('body').css('cursor', '');

            if (classAdded) {
                element.removeClass('unselectable');
            }
            var elCached = element;
            setTimeout(function () {
                elCached.unbind('click.dragndrop');
                elCached = null;
            }, 10); // hack чтобы успел отработать click и попасть в обработчик, где отменится дефлотное поведение. Нужно, чтобы тык по ссылкам во время драгндропа не срабатывал.

            if (dropTarget) {
                dropTarget.css('opacity', '');
            }

            if (intersects()) {
                if (dropCallbackFn) {
                    dropCallbackFn(element, dropTarget);
                }
            } else {
                dragndrop.cancelDragging(element);
            }

            started = false;
            element = null;
            dropTarget = null;
            dropCallbackFn = null;
        }
    };
    dragndrop.cancelDragging = function(element) {
        if (!element instanceof jQuery) {
            element = $(element);
        }
        element.removeClass('dragndrop-elem-dragging');
        element.css({
            left: '',
            top: ''
        });
    };
})(window.dragndrop = {});

var topper = new function(){
  var self = this,
      sideHeight = 0, bufferTop = 0, toUp = true, toUpEl = null, toUpSide = null, widthContent = null;

  self.init = function(){
    self.update();
    toUpEl = $('#topper-block');
    toUpSide = $('#topper-side');

    $(window).bind('resize', self.checkWidth).bind('scroll', topper.onScroll);
    self.checkWidth();
  };
  // update method
  self.update = function(){
    sideHeight = ge('side-content') ? ge('side-content').clientHeight : 0;
  };

  self.onScroll = function(){
    var delta = fs.scrollTop - sideHeight;
    toUpSide.hide();
    if(delta > 0) {
      toUpEl.addClass('on').removeClass('to-bottom');
      if(!toUp) toUpEl.html('<div class="topper-inner">Наверх <i class="icn icn-gray icn-up"></i></div>');
      toUp = true;
    } else if(delta < 0 && !toUp) {
      toUpEl.addClass('on to-bottom').html('<div class="topper-inner"><i class="icn icn-gray icn-down"></i></div>');
      toUpSide.show().css({
        'top' : -delta + 55
      })
    } else if(delta < 0) { toUpEl.removeClass("on to-bottom"); }
  };

  self.onClick = function(){
    if(toUp) {
      bufferTop = fs.scrollTop;
      $(window).scrollTop(0);
      toUp = false;
      toUpEl.html('<div class="topper-inner"><i class="icn icn-gray icn-down"></i></div>');
    } else {
      $(window).scrollTop(bufferTop);
      toUp = true;
      toUpEl.html('<div class="topper-inner">Наверх <i class="icn icn-gray icn-up"></i></div>');}
  };

  self.checkWidth = function(){
    var width = document.documentElement.clientWidth;
    toUpEl[((width < 1290 && width > 1240) || (width < 1070) ? 'add' : 'remove') + 'Class']('to-bottom-hide');
    if(width < 1024){
      toUpEl.attr('style', 'margin: 0 ' + (width/2 - 170) + 'px 0 0; top: 0');
      toUpSide.attr('style', 'margin: 0 ' + (width/2 - 170) + 'px 0 0;');
    } else {
      toUpEl.removeAttr('style');
    }
  };

  self.sideOver = function(){toUpEl.addClass('hover');};
  self.sideOut = function(){toUpEl.removeClass('hover');};

  self.clear = function(){ $(toUpEl).removeClass('on with-menu').html('<div class="topper-inner">Наверх <i class="icn icn-gray icn-up"></i></div>'); toUp = true; $(toUpSide).hide();};
  self.destroy = function(){ self.clear(); $(window).unbind('resize', self.checkWidth).unbind('scroll', topper.onScroll);}
};

messageFormEventer = new Eventer({ eventPrefix: '' });
(function () {
    var MessageForm = window.MessageForm = function (uid, config) {
        if (arguments[0]) {
            this.uid = uid;
            this.init(config);
        }
    };
    var proto = MessageForm.prototype = {};
    proto._defaultConfig = {
        expandedClass       : 'message-form-expanded',
        hasTextClass        : 'message-form-has-text',
        enabledClass        : 'message-form-enabled',
        saveButtonSelector  : '.message-form-save-btn',
        textAreaSelector    : '.message-form-text',
        limitTextSelector   : '.message-form-limit',
        placeholderSelector : '.message-form-placeholder',
        smilesBtnSelector   : '.message-form-smiles',
        attachPhotoBtnSelector   : '.message-form-photo',
        attacherId          : 'message-form-attacher',
        attacherFormId      : 'message-form-form',
        negativeLimitClass  : 'message-form-limit-negative',
        btnDisabledClass    : 'btn-disabled',
        additionalContentEnabled   : false,
        additionalDataCache : [],
        additionalDataSelector : '.message-form-attachments',
        textLimit           : 280
    };
    proto.applyConfig = function (config) {
        $.extend(this, this._defaultConfig, config);
    };
    proto.getContainer = function () {
        if (this.uid) {
            this.container = $('#messageForm'+this.uid);
        }
    };
    proto.init = function (config) {
        var me = this;

        this.applyConfig(config);

        this.getContainer();

        this.container.bind('mousedown', function (event) {
            cancelEvent(event);
            return false;
        });

        this.textArea = this.container.find(this.textAreaSelector);
        this.textArea.removeAttr('ondrop');
        this.textArea.removeAttr('keydown');
        var fn = function () {
                me.onChange();
            },
            delayedFn = function () {
                setTimeout(fn, 0);
            };
        this.textArea.bind('change', fn);
        if(this.additionalContentEnabled){
            this.textArea.bind('paste', function(){ st( function(){ me.parseLinks.call(me); }, 0); });
            this.textArea.bind('cut drop keydown', delayedFn);
        } else {
            this.textArea.bind('cut paste drop keydown', delayedFn);
        }
        this.textArea.bind('mousedown', function (event) {
            sp(event);
        });

        this.saveButton = this.container.find(this.saveButtonSelector);

        this.limitText = this.container.find(this.limitTextSelector);

        this.placeholder = this.container.find(this.placeholderSelector);

        this.smilesBtn = this.container.find(this.smilesBtnSelector);

        this.attachPhotoBtn = this.container.find(this.attachPhotoBtnSelector);

        if(this.additionalContentEnabled)
            this.additionalDataContainer = this.container.find(this.additionalDataSelector);

        this._saveCheckFn();
    };
    proto._makeFakeTextarea = function () {
        if (this.textAreaFake) return;
        this.textAreaFake = this.textArea.clone();
        this.textAreaFake
            .removeAttr('name onfocus onblur onkeydown ondrop oncut onpaste id')
            .css({
                position: 'absolute',
                visibility: 'hidden',
                height: 'auto',
                padding: 0
            });
        this.textArea.after(this.textAreaFake);
    };
    proto._removeFakeTextarea = function () {
        if (!this.textAreaFake) return;
        this.textAreaFake.remove();
        this.textAreaFake = null;
    };
    proto._saveFn = function () {
        console.warn('MessageForm._saveFn is an abstract method and must be overriden');
    };
    proto.save = function () {
        if (this.checkSave()) {
            this.disable();
            this.textArea.attr('disabled', true);
            this._saveFn();
        }
    };
    proto.checkSave = function () {
        if (!this.isEnabled()) return false;
        if (this.textLimit && this.get(true).length > this.textLimit) {
            fs.notify('Максимальный объём текста превышен');
            return false;
        }
        return true;
    };
    proto.setLimitText = function () {
        if (this.limitText.length) {
            var d = this.textLimit - this.get().length;
            if (d < 0) {
                d = -d;
                this.limitText.addClass(this.negativeLimitClass);
                this.limitText.text('Объём превышен на ' + d + fs.plural(d, ' символ', ' символа', ' символов'));
            } else {
                if (d < 15) {
                    this.limitText.removeClass(this.negativeLimitClass);
                    this.limitText.text(fs.plural(d, 'Остался '+d+' символ', 'Осталось '+d+' символа', 'Осталось '+d+' символов'));
                } else {
                    this.limitText.empty();
                }
            }
        }
    };
    proto.expand = function () {
        this.container.addClass(this.expandedClass);
        this._makeFakeTextarea();
    };
    proto.collapse = function () {
        this.container.removeClass(this.expandedClass);
        if (this.smilesBtn.size()) {
            smilesTooltip.hide(this.smilesBtn[0]);
        }
        this._removeFakeTextarea();
    };
    proto._onClick = function (event) {
        this.save();
    };
    proto._onFocus = function (event) {
        this.expand();
    };
    proto._onBlur = function (event) {
        if (!this.get(true).length) {
            this.collapse();
        }
    };
    proto._onKeyDown = function (event) {
        switch (event.keyCode) {
        case 27: // Esc
            if (!this.isEnabled()) {
                this.blur();
            }
            break;
        case 13: // Enter
            if (event.ctrlKey) {
                this.save();
            }
            break;
        }
    };
    proto.focus = function () {
        this.textArea.focus();
    };
    proto.blur = function () {
        this.textArea.blur();
    };
    proto.enable = function () {
        if (!this.isEnabled()) {
            this.container.addClass(this.enabledClass);
            this.saveButton.removeClass(this.btnDisabledClass);
            if (this.textArea.attr('disabled')) {
                this.textArea.removeAttr('disabled');
            }
        }
    };
    proto.disable = function () {
        if (this.isEnabled()) {
           this.container.removeClass(this.enabledClass);
           this.saveButton.addClass(this.btnDisabledClass);
        }
    };
    proto._saveCheckFn = function () {
        if (this.textArea.attr('disabled')) return;
        var text = this.get(true);
        if (text.length) {
            this.container.addClass(this.hasTextClass);
            this.enable();

            if (!this.textAreaFake) {
                this._makeFakeTextarea();
            }
            this.textAreaFake.val(this.textArea.val());
            this.textArea.css({
                height: this.textAreaFake[0].scrollHeight
            });
        } else {
            this.container.removeClass(this.hasTextClass);
            this.disable();
            this.textArea.css('height', '');
        }
        if (this.textLimit) {
            this.setLimitText();
        }
    };
    proto.parseLinks = function(){
        var context = this,
            text = this.get(true),
            i, j, alreadyParsed,
            urls = text.match(/(https?:\/\/([a-z0-9-]+[.])+([a-z]{2,4}))(?:(\/[^\s]+)|[^a-z]|$)/ig);

        if(typeof urls !== 'undefined'){
            for(i in urls){
                alreadyParsed = false;
                for(j in context.additionalDataCache){
                    if(context.additionalDataCache[j].indexOf([urls[i]]) > -1){
                        alreadyParsed = true;
                        break;
                    }
                }
                if(!alreadyParsed){
                    context.additionalDataCache.push(urls[i]);
                    context.parseUrl(urls[i]);
                }
            }
        }
    };
    proto.subscribeToEventer = function(eventName, uid){
        var context = this;
        messageFormEventer.on(eventName+'.'+uid, function(event, data){ context['on'+eventName].call(context, data, uid); } );
        if(eventName == 'parseComplete')
            st(function(){context.unsubscribeToEventer('parseComplete', uid); }, 5000);
    };
    proto.unsubscribeToEventer = function(eventName, uid){
        messageFormEventer.off(eventName+'.'+uid);
    };
    proto.onparseComplete = function(data, uid){
        if(data.task != uid)
            return false;
        if(!this.additionalData)
            this.additionalData = {};
        if(data.type == 'img'){
            this.additionalData['img'+data.imageId] = {type: 'img', id: data.imageId, url: data.previewUrl};
        } else if(data.type == 'site'){
            this.additionalData['site'+data.siteId+'_'+data.linkId] = {type: 'site', id: data.siteId+'_'+data.linkId, imgId: data.imageId, url: data.previewUrl };
        }
        this.additionalDataContainer.html(this.renderAdditionalData());
        this.unsubscribeToEventer('removeAttachment', uid);
        this.subscribeToEventer('removeAttachment', uid);
        this.unsubscribeToEventer('parseComplete', uid);
    };
    proto.onremoveAttachment = function(data, uid){
        if(typeof this.additionalData[data.uid] !== 'undefined'){
            delete this.additionalData[data.uid];
            var html = this.renderAdditionalData();
            this.additionalDataContainer.html(html)[html ? 'removeClass' : 'addClass']('d-n');
        }
    };
    proto.onChange = function () {
        this._saveCheckFn();
    };
    proto.isEnabled = function () {
        return this.container.hasClass(this.enabledClass);
    };
    proto.set = function (text) {
        if(this.additionalContentEnabled && typeof text === 'object'){
            var html = this.renderAdditionalData(text.additionalData, true),
                totalPhotos = 0;
            this.additionalDataContainer.html(html)[html ? 'removeClass' : 'addClass']('d-n');
            if(typeof this.uploaderObj === 'object'){
                for(var i in this.additionalData){
                    totalPhotos++;
                }
                this.uploaderObj.totalPhotos = totalPhotos;
            }
            text = text.text;
        }
        this.textArea.val(text);
        this._saveCheckFn();
    };
    proto.get = function (isEmpty) {
        if(isEmpty || !this.additionalContentEnabled) {
            var result = this.textArea.val();
            if(!result.length && this.additionalData)
                result = 'true';
            return result;
        } else {
            var text = this.textArea.val();
            if(text.length > 0){
                text = text.split('[img:');
                if(text.length > 1){
                    for(var i=1; i<text.length; i++){
                        if(text[i].indexOf(']') > -1)
                            text[i] = text[i].slice(text[i].indexOf(']')+1);
                    }
                }
                return text.join('');
            } else {
                return text;
            }
        }
    };
    proto.parseUrl = function (url) {
        var context = this;
        fs.post('/attach/upload/', {url: url, ajax: 1, ownerType:1, ownerId: currentUser.userId}, {
            onError:function(data){
                return false;
            },
            onSuccess:function(data){
                if (data.result) {
                    context.currentParseTaskId = null;
                    context.onparseComplete(data.result);
                } else {
                    context.currentParseTaskId = data.task;
                    context.subscribeToEventer('parseComplete', data.task);
                }
            }
        });
    };
    proto.getData = function(dataType){
        var context = this,
            newData = false,
            i, dataItem;
        dataType = dataType || 'img';

        if(context.additionalData){
            for(i in context.additionalData){
                dataItem = context.additionalData[i];
                if(dataItem.type == dataType){
                    if(!newData) newData = {};
                    newData[i] = dataItem;
                }
            }
        } else {
            newData = '';
        }
        return newData;
    };
    proto.getSerializedData = function(dataType){
        if(!this.additionalContentEnabled)
            return false;
        var result = '',
            data = '';
        if(!dataType){
            dataType = ['img', 'site', 'json'];
        } else {
            dataType = (typeof dataType === 'string') ? [dataType] : dataType;
        }
        for(var j in dataType){
            if(dataType[j] != 'json'){
                data = this.getData(dataType[j]);
                for(var i in data){
                    if(data[i].type && data[i].id && data[i].url){
                        result += '['+data[i].type+':'+data[i].id+':'+data[i].url.replace(/\./g, ',')+']';
                    }
                }
            } else {
                data = this.getData('photo');
                if(data)
                    result += '[json:'+JSON.stringify(data).replace(/\]/g, '\]').replace(/\[/g, '\[') +']';
            }
        }
        return result.length > 0 ? ' '+result : false;
    };
    proto.renderAdditionalData = function(text, forceDataUpdate){
        if(!this.additionalContentEnabled)
            return false;
        var data = false,
            result = '',
            i,
            series = '';

        data = text ? this.constructor.getData(text, 'img') : this.getData('img');
        if(data){
            if(text && text.length && !forceDataUpdate){
                for(i in data){
                    series += (series.length ? ',' : '')+data[i].id;
                }
                for(i in data){
                    result += '<div class="comments-attachment-img" onclick="showPhoto({photoid: '+data[i].id+', '+ (series.length ? 'series: \''+series+'\', ': '') +'type: 6})"><img src="'+data[i].url.replace(/,/g, '.')+'" /></div>';
                }
            } else {
                if(forceDataUpdate) {
                    this.additionalData = this.additionalData || {};
                    $.extend(this.additionalData, data);
                }
                for(i in data){
                    series += data[i].id;
                }
                for(i in data){
                    result += '<div class="comments-attachment-img" onclick="showPhoto({photoid: '+data[i].id+', '+ (series.length ? 'series: \''+series+'\', ': '') +'type: 6})">'
                        +'<img src="'+data[i].url.replace(/,/g, '.')+'" />'
                        +'<span class="comments-attachment-remove tr-opacity-03" onclick="messageFormEventer.emit(\'removeAttachment\', {uid: \'img'+data[i].id+'\'}); sp(event);">'
                            +'<i class="icn icn-close icn-white"></i>'
                        +'</span>'
                    +'</div>';
                }
            }
        }

        data = text ? this.constructor.getData(text, 'site') : this.getData('site');
        if(data){
            if(text && text.length && !forceDataUpdate){
                // asch' asch'
            } else {
                if(forceDataUpdate) {
                    this.additionalData = this.additionalData || {};
                    $.extend(this.additionalData, data);
                }
                for(i in data){
                    result += '<div class="comments-attachment-site">'
                            +'<span class="comments-attachment-site-anchor">Ссылка <i class="icn icn-close icn-gray" onclick="messageFormEventer.emit(\'removeAttachment\', {uid: \'site'+data[i].id+'\'}); sp(event);"></i></span>'
                            +'<div class="comments-attachment-site-box">'
                                +'<h3 class="comments-attachment-site-title">Морфология. Задачи и подходы к их решению</h3>'
                                +'<img class="comments-attachment-site-preview" src="'+data[i].url.replace(/,/g, '.')+'" />'
                                +'<p class="comments-attachment-site-description">Содержание цикла статей про морфологию • Морфология и компьютерная лингвистика для самых маленьких • Роль морфологии в компьютерной лингвистике • Морфология. Задачи и подходы к их решению • Псевдолемматизация, композиты и прочие странные словечки В прошлой статье мы вплотную подошли к решению задачи</p>'
                            +'</div>'
                        +'</div>';
                }
            }
        }

        data = text ? this.constructor.getData(text, 'json') : this.getData('json');
        if(data){
            if(text && text.length && !forceDataUpdate){
                for(i in data){
                    series += (series.length ? ',' : '')+data[i].id;
                }
                for(i in data){
                    result += '<div class="comments-attachment-img" onclick="showPhoto({photoid: '+data[i].id+', '+ (series.length ? 'series: \''+series+'\', ': '') +'type: 6})"><img src="'+data[i].url+'" /></div>';
                }
            } else {
                if(forceDataUpdate) {
                    this.additionalData = this.additionalData || {};
                    $.extend(this.additionalData, data);
                }
                for(i in data){
                    series += data[i].id;
                }
                for(i in data){
                    if(forceDataUpdate && typeof this.uploaderObj === 'object'){
                        this.unsubscribeToEventer('removeAttachment', 'photo'+data[i].id);
                        this.subscribeToEventer('removeAttachment', 'photo'+data[i].id);
                    }
                    if(typeof this.renderAttachmentPhoto === 'function'){
                        result += this.renderAttachmentPhoto(data[i]);
                    } else {
                        result += '<div class="message-form-photo-preload-wrap" onclick="showPhoto({photoid: '+data[i].id+', '+ (series.length ? 'series: \''+series+'\', ': '') +'type: 6})">'
                            +'<img class="message-form-photo-preload-img" src="'+data[i].url+'" />'
                            +'<div class="message-form-photo-preload-delete message-form-photo-preload-action-btn tr-opacity-03" onclick="messageFormEventer.emit(\'removeAttachment\', {uid: \'photo'+data[i].id+'\', element: $(this).closest(\'.message-form-photo-preload-wrap\')}); sp(event);"><i class="icn icn-light-gray icn-cross"></i></div>'
                            +'</div>';
                    }
                }
            }
        }
        // there should be renders for other data types
        return result.length ? '<div class="comments-attachments-wrap">'+result+'</div>' : '';
    };
    proto.getSimpleData = function(text){
        var dataTypes = ['img', 'vid', 'site', 'json'],
            result = typeof text !== 'undefined' ? text : this.textArea.val();
        for(var i in dataTypes){
            result = result.split('['+dataTypes[i]+':')[0];
        }
        return result == text ? text : result.slice(0, -1);
    };
    proto.reset = function () {
        if (this.textArea.attr('disabled')) {
            this.textArea.removeAttr('disabled');
        }
        if(this.additionalContentEnabled){
            this.additionalData = false;
            this.additionalDataContainer.empty();
            this.additionalDataCache = [];
        }
        this.set('');
        this.blur();
    };

    function checkOffsets(el, start, end) {
        start = (start < 0) ? start + el.value.length : start;
        end = (typeof end == 'undefined') ? start : (end < 0) ? end + el.value.length : end;
        return {start:start, end:end};
    }
    function offsetToRange(el, offset) {
        return offset - (el.value.slice(0, offset).split("\r\n").length - 1);
    }
    var getSelection = function(t) {
        var el = t[0];
        var start = 0, end = 0, text = '';
        if (typeof el.selectionStart !== 'undefined') {
            start = el.selectionStart;
            end = el.selectionEnd;
            text = el.value.slice(start, end);
        } else if (typeof document.selection == 'object') {
            var textRange, endRange, len = el.value.length, range = document.selection.createRange();
            if (range && range.parentElement() == el) {
                text = el.value.replace(/\r\n/g, "\n");
                textRange = el.createTextRange();
                endRange = el.createTextRange();
                textRange.moveToBookmark(range.getBookmark());
                endRange.collapse(false);
                if (textRange.compareEndPoints('StartToEnd', endRange) > -1) {
                    start = end = len;
                } else {
                    start = -textRange.moveStart('character', -len);
                    start += text.slice(0, start).split("\n").length - 1;
                    if (textRange.compareEndPoints('EndToEnd', endRange) > -1) {
                        end = len;
                    } else {
                        end = -textRange.moveEnd('character', -len);
                        end += text.slice(0, end).split("\n").length - 1;
                    }
                }
            } else if (t.data('lastSelection')) {
                var data = t.data('lastSelection');
                start = data.start;
                end = data.end;
                text = data.text;
            } else {
                start = end = len;
            }
        }
        return {start:start, end:end, text:text};
    };
    var setSelection = function(t, start, end) {
        var el = t[0];
        var offsets = checkOffsets(el, start, end);
        if (typeof el.selectionStart != 'undefined') {
            el.selectionStart = offsets.start;
            el.selectionEnd = offsets.end;
        } else if (typeof document.selection == 'object') {
            var range = el.createTextRange();
            var startCharMove = offsetToRange(el, offsets.start);
            range.collapse(true);
            if (offsets.start == offsets.end) {
                range.move("character", startCharMove);
            } else {
                range.moveEnd("character", offsetToRange(el, offsets.end));
                range.moveStart("character", startCharMove);
            }
            range.select();
        }
    };
    var replaceSelection = function(t, text) {
        var sel = getSelection(t), v = t.val();
        t.focus();
        var idx = sel.start + text.length;
        t.val(v.slice(0, sel.start) + text + v.slice(sel.end));
        setSelection(t, idx);
    };
    proto.getSelection = function () {
        getSelection(this.textArea);
    };
    proto.setSelection = function (start, end) {
        setSelection(this.textArea, start, end);
    };
    proto.replaceSelection = function (text) {
        replaceSelection(this.textArea, text);
    };

    MessageForm.extend = function() {
        var Parent = this,
            Child = function (config) {
                Parent.call(this, config);
            };
        Child.prototype = new Parent();
        Child._super = Parent.prototype;
        Child.prototype._defaultConfig = $.extend({}, Child._super._defaultConfig);
        Child.prototype.constructor = Child;
        Child.getData = Parent.getData;
        return Child;
    };
    MessageForm.getData = function(text, dataType){
        var context = this,
            newData = false,
            i, json, id, url;
        dataType = dataType || 'img';

        if(text && text.length < 5) return newData;
        text = text.split('['+dataType+':');
        if(text.length > 1){
            for(i=1; i<text.length; i++){
                text[i] = text[i].slice(0, text[i].indexOf(']'));
                newData = newData || {};
                if(dataType != 'json'){
                    id = text[i].split(':')[0];
                    url = text[i].slice(id.length + 1);

                    newData[dataType + id] = {
                        type : dataType,
                        id : id,
                        url : url
                    };
                } else {
                    try {
                        json = JSON.parse(text[i]);
                        $.extend(newData, json);
                    } catch(e){}
                }
            }
        }
        return newData;
    };

    var messageForm = window.messageForm = {
        cache: {},
        formConstructor: MessageForm,
        isInited: false,
        init: function () {
            if (!this.isInited) {
                var me = this;
                nav2.gc(function () {
                    me.destroy();
                });
                this.isInited = true;
            }
        },
        getInstance: function (uid) {
            if (!this.isInited) {
                this.init();
            }
            return this._getInstanceFn(uid);
        },
        _getInstanceFn: function (uid) {
            if (!this.cache[uid]) {
                this.cache[uid] = new this.formConstructor(uid);
            }
            return this.cache[uid];
        },
        renderAdditionalData: function(text){
            return this.getInstance().renderAdditionalData(text);
        },
        getSimpleData: function(text){
            return this.getInstance().getSimpleData(text);
        },
        getData: function(text, dataType){
            if(typeof text === 'string'){
                return this.formConstructor.getData(text, dataType);
            } else {
                return this.getInstance().getData(dataType);
            }
        },
        destroy: function () {
            this.isInited = false;
            this._destroyFn();
        },
        _destroyFn: function () {
            this.cache = {};
        },
        edit: function (uid) {
            this.getInstance(uid).expand();
        },
        set: function (uid, text) {
            this.getInstance(uid).set(text);
        },
        get: function (uid) {
            this.getInstance(uid).get();
        },
        save: function (uid) {
            this.getInstance(uid).save();
        },
        focus: function (uid) {
            this.getInstance(uid).focus();
        },
        blur: function (uid) {
            this.getInstance(uid).blur();
        },
        onKeyDown: function (uid, event) {
            this.getInstance(uid)._onKeyDown(event);
        },
        onFocus: function (uid, event) {
            this.getInstance(uid)._onFocus(event);
        },
        onBlur: function (uid, event) {
            this.getInstance(uid)._onBlur(event);
        },
        onDrop: function (uid, event) {
            var me = this;
            setTimeout(function () {
                me.getInstance(uid)._saveCheckFn();
            }, 0);
        }
    };
})();

var smilesTooltip = {
    config: null,
    showBy: 100,
    showed: 0,
    messageForm: null,
    tooltip: null,
    scrollbar: false,
    show : function(element, messageForm, tooltipClass, animatedSmiles){
        var node_heap = $('#node-heap-smiles-tooltip');
        if (!node_heap.length) {
            node_heap = $('<div>', {'id': 'node-heap-smiles-tooltip'}).appendTo($('#node-heap'));
        }

        smilesTooltip.tooltipClass = tooltipClass;
        var btn = $(element);
        if (smilesTooltip.tooltip) { // Костыль для того, чтобы не создавалось over9000 тултипов в ДОМе для каждой кнопки смайла
            if (smilesTooltip.tooltip.element[0] != element && smilesTooltip.tooltip.is_visible) { // попап открыт на другой кнопке, нужно его сначала закрыть
                smilesTooltip.tooltip.wrapper.css({opacity: 0});
                smilesTooltip.tooltip.is_visible = false;
                smilesTooltip.tooltip.element.removeClass('on');
            }
            element.tooltip = smilesTooltip.tooltip;
            element.tooltip.element = btn;
        }
        if (btn.hasClass('on')) {
            smilesTooltip.hide(element);
        } else {
            smilesTooltip.messageForm = messageForm;
            var btn = $(element).addClass('on');
            AnyTooltip.show(element, {
                content: {
                    func: function(tooltip){
                        if(!smilesTooltip.config){
                            $.get('/usercontact/ajax/getusersmiles/', $.extend({}, {animated: animatedSmiles}),function(response){
                                if (response && response.ret == 1) {
                                    smilesTooltip.config = $.merge(response.free, response.premium);
                                } else {
                                    smilesTooltip.config = [];
                                }
                                tooltip.html(smilesTooltip.render());
                                smilesTooltip.scrollbar = new Scrollbar(tooltip.wrapper.find('.smiles-tooltip-box'), { more: smilesTooltip.more });
                            }, 'JSON');
                        } else {
                            tooltip.html(smilesTooltip.render());
                            smilesTooltip.scrollbar = new Scrollbar(tooltip.wrapper.find('.smiles-tooltip-box'), { more: smilesTooltip.more });
                        }
                        nav2.gc(smilesTooltip.destroy, 'smilesTooltipGc');
                    }
                },
                style: {
                    show_delay: 1,
                    show_distance: 10,
                    show_duration: 180,
                    hide_delay: 1,
                    hide_distance: 10,
                    hide_duration: 180,
                    no_close: true,
                    node_heap: '#node-heap-smiles-tooltip',
                    animate_open: function(me){
                        smilesTooltip.tooltip = me;
                        me.wrapper.attr('onmousedown', 'cancelEvent(event); return false;')
                            .removeClass()
                            .addClass('iTooltip smiles-tooltip ' + (smilesTooltip.tooltipClass||''));

                        var wrap = me.element,
                            finalX = Math.round(-(wrap.offset().left + wrap.width())),
                            finalY = Math.round(-(wrap.offset().top - 5));

                        if (smilesTooltip.scrollbar) {
                            smilesTooltip.scrollbar.update(false, true);
                            smilesTooltip.scrollbar.val(smilesTooltip.scrollbar_top || 0);
                        }

                        me.arrow.css({right: wrap.width()/2});

                        me.wrapper
                            .css({ right: finalX, bottom: finalY + me.show_distance, opacity: 0 })
                            .stop()
                            .animate({ bottom: finalY, opacity: 1 }, me.show_duration);
                    },
                    animate_close: function(me){
                        smilesTooltip.scrollbar_top = smilesTooltip.scrollbar.val();
                        me.wrapper
                            .stop()
                            .animate({ bottom: '+=' + me.hide_distance, opacity: 0 }, me.hide_duration, function(){
                                me.wrapper.css('right', 10000);
                                me.is_visible = false;
                            });
                    }
                }
            });

            if (!element.hideSmilesTooltip) element.hideSmilesTooltip = function(event){ smilesTooltip.hide(element, event); };
            st(function(){ $(document).bind('click', element.hideSmilesTooltip); }, 0);
        }

    },
    hide: function(element, event){
        if (checkEvent(event)) return;

        var t = event && $(event.target);
        if (t && (t.hasClass('smiles-tooltip') || t.parent().hasClass('smiles-tooltip-box') || t.parent().parent().hasClass('smiles-tooltip-box'))) return;

        if (element && element.hideSmilesTooltip) st(function(){ $(document).unbind('click', element.hideSmilesTooltip); }, 0);
        $(element).removeClass('on');
        AnyTooltip.hide(element);
        smilesTooltip.messageForm = null;
        smilesTooltip.showed = 0;
    },
    render: function () {
        var res = '<div class="smiles-tooltip-box"><div class="smiles-tooltip-inner"><div class="smiles-tooltip-list">';
        res += smilesTooltip.renderPortion();
        res += '</div></div></div>';
        return res;
    },
    renderPortion: function () {
        var res = '', smileTxt;
        for (var i = smilesTooltip.showed, l = Math.min(smilesTooltip.showed + smilesTooltip.showBy, smilesTooltip.config.length), smile; i < l; i++ ) {
            smilesTooltip.showed++;
            smile = smilesTooltip.config[i];
            smileTxt = smile.text.replace(/\\/g, '\\\\').replace(/'/g, '\\\'');
            res += '<img src="' + smile.url + '" onload="if (smilesTooltip.scrollbar) smilesTooltip.scrollbar.update(false, true);" onclick="smilesTooltip.insert(\'' + smileTxt + '\');" alt="'+smileTxt+'" title="'+smileTxt+'" />';
        }
        return res;
    },
    insert: function (smileStr) {
        if (smilesTooltip.messageForm) {
            smilesTooltip.messageForm.replaceSelection(' ' + smileStr + ' ');
            smilesTooltip.messageForm.textArea.triggerHandler('change');
        }
    },
    more: function(){
        if (smilesTooltip.scrollbar) {
            var portion = smilesTooltip.renderPortion();
            if (portion.length) {
                smilesTooltip.scrollbar.content.append(portion);
                smilesTooltip.scrollbar.update(false, true);
            } else {
                smilesTooltip.scrollbar.options.more = null;
            }
        }
    },
    destroy: function () {
        smilesTooltip.showed = 0;
        smilesTooltip.messageForm = null;
        smilesTooltip.tooltip = null;
        delete smilesTooltip.scrollbar;
        smilesTooltip.scrollbar = false;
    }
};

var mutualFriendsPopup = function(friendId) {
    $.get('/friends/ajax/sourcessuggestedfriends/',
        {
            friendId:friendId,
            ajax: 1
        },
        function (response) {
            if (response.ret == 1) {
                iPopup.open(response.html, {
                    title: "Ваши общие друзья",
                    style: {
                        width: 682
                    },
                    onopen: function(){
                        var source_friends_scrollbar = new Scrollbar('scrollbar-source-friends-wrap');
                    }
                });
            } else {
                fs.notify(response.message);
            }
        },
        'JSON'
    );

    return false;
};

/*
 * Попап с двумя списками с возможностью переносить элементы из одного в другой и сохранять изменения.
 */
var listManagePopup = function (opts) {
    this.construct(opts);
};

listManagePopup.prototype = {
    construct: function (opts) {
        var self = this;

        $.extend(self, {
            title: ' ',
            listTitles: ['Первый список', 'Второй список'],
            emptyMessages: ['Список пуст.', 'Список пуст.'],
            inputPlaceholder: '',
            width: 500,
            closeOnSave: true,
            footer: '<div class="ibtn ibtn-blue btn-save">Сохранить</div>',
            myclass: 'list-manage-popup',
            loadAjaxUrl: '',
            saveAjaxUrl: '',
            flySearch: false
        }, opts);
        self.managedItemIds = [{}, {}];
        self.offsets = [0, 0];
        self.hasNext = [true, true];
        self.filter = '';
        self.loadLocks = false;
        self.saveLocks = false;

        self._onAjaxLoadSuccess = function (res) {
            self.onLoadSuccess(res);
        };
        self._onAjaxSaveSuccess = function (res) {
            self.onSaveSuccess(res);
        };
        self._onOpen = function (popup) {
            self.onOpen(popup);
        };
        self._onClose = function (popup) {
            self.onClose(popup);
        };
        self._onSaveClick = function () {
            self.save();
        };
    },
    tpl: function () {
        return '<div class="filter-input-wrap"><input class="filter-input form-input" placeholder="'+this.inputPlaceholder+'" /></div>'+
                '<ul class="managed-lists nclear">'+
                    '<li class="managed-list-wrap managed-list1">' +
                        '<div class="managed-list-title">'+this.listTitles[0]+'</div>' +
                        '<div class="managed-list-scrollarea unselectable"><div class="managed-list-inner"><ul class="managed-list"></ul></div>'+
                    '</li>'+
                    '<li class="managed-lists-divider"></li>' +
                    '<li class="managed-list-wrap managed-list2">' +
                        '<div class="managed-list-title">'+this.listTitles[1]+'</div>' +
                        '<div class="managed-list-scrollarea unselectable"><div class="managed-list-inner"><ul class="managed-list"></ul></div>'+
                    '</li>'+
                '</ul>'
    },
    open: function () {
        var self = this;

        iPopup.open(self.tpl(), $.extend({
            title: self.title,
            footer: self.footer,
            style: {
                width: self.width,
                myclass: self.myclass
            },
            onopen: self._onOpen,
            onclose: self._onClose
        }, self.popupConfig));

        self.lists = self.popup.inner.find('.managed-list');
        self.lists.on('click', '.managed-list-item', function () {
            self.swap($(this));
        });

        // self.lists.eq(0).append('<li class="managed-list-empty-item">'+self.emptyMessages[0]+'</li>');
        // self.lists.eq(1).append('<li class="managed-list-empty-item">'+self.emptyMessages[1]+'</li>');

        self.lists[0].scrollbar = new Scrollbar(self.lists.eq(0).closest('.managed-list-scrollarea')[0], {
            more: function(){
                if (self.hasNext[0]) self.load(false, 0);
            }
        });
        self.lists[1].scrollbar = new Scrollbar(self.lists.eq(1).closest('.managed-list-scrollarea')[0], {
            more: function(){
                if (self.hasNext[1]) self.load(false, 1);
            }
        });

        self.load(true);

        self.filterInput = self.popup.inner.find('.filter-input');

        if (self.flySearch) {
            self.flySearch = new flySearch($.extend({
                element: self.filterInput,
                ajaxUrl: true,
                onSearch: function (params) {
                    self.filter = params.query;
                    self.offsets = [0, 0];
                    self.load(true);
                },
                onCancel: function () {
                    self.filter = '';
                    self.offsets = [0, 0];
                    self.load(true);
                }
            }, self.flySearch));

            self.filterInput.keyup(function () {
                self.flySearch.search();
            });
        }
    },
    close: function () {
        if (this.popup) {
            iPopup.close();
            this.popup = null;
        }
    },
    load: function (clearBefore, listIndex) {
        if (this.loadLock) return;

        this.loadLock = true;
        this.clearBefore = clearBefore;

        this.showPreloader(listIndex);

        $.get(this.loadAjaxUrl, $.isFunction(this.loadAjaxParams) ? this.loadAjaxParams() : this.loadAjaxParams, this._onAjaxLoadSuccess, 'json');
    },
    showPreloader: function (listIndex) {
        var lists = typeof listIndex == 'undefined' ? [0, 1] : [listIndex];

        for (var i = 0; i < lists.length; i++) {
            this.lists.eq(i).append('<li class="manage-item-preloader"><i class="icn icn-process"></i></li>');
        }
    },
    hidePreloader: function (listIndex) {
        this.lists.find('.manage-item-preloader').remove();
    },
    empty: function (listIndex) {
        if (typeof listIndex == 'undefined') {
            this.lists.empty();
            this.offsets[0] = 0;
            this.offsets[1] = 0;
            this.hasNext[0] = true;
            this.hasNext[1] = true;
        } else {
            this.lists.eq(listIndex).empty();
            this.offsets[listIndex] = 0;
            this.hasNext[listIndex] = true;
        }
    },
    loadAjaxParams: function (listIndex) {
        var offsets = (typeof listIndex == 'undefined') ? this.offsets : [-1, -1];
        if (typeof listIndex != 'undefined') {
            offsets[listIndex] = this.offsets[listIndex];
        }

        return {
            offsets: offsets,
            filter: this.filter
        }
    },
    isChanged: function () {
        for (var i = 0, j; i < this.managedItemIds.length; i++) {
            for (j in this.managedItemIds[i]) {
                if (this.managedItemIds[i][j]) return true;
            }
        }

        return false;
    },
    saveAjaxParams: function () {
        return {
            lists: this.managedItemIds
        };
    },
    // перекладываем элементы, расположенные не в своей колонке, но еще не сохраненные
    reassembleLists: function (lists) {
        for (var ii = 0, ll = lists.length, currList, oppositeList, ij; ii < ll; ii++) {
            currList = lists[ii].data;

            if (!currList) continue;

            ij = (ii+1)%2;
            oppositeList = lists[ij].data;

            for (var i = 0, id; i < currList.length; ) {
                id = this.getDataId(currList[i]);
                if (this.managedItemIds[ij][id]) { // нашли элемент в противоположном списке
                    oppositeList.splice(Math.min(i, oppositeList.length-1), 0, currList[i]);
                    currList.splice(i, 1);
                } else {
                    i++;
                }
            }
        }
    },
    onLoadSuccess: function (res) {
        this.hidePreloader();
        if (res.ret == 1) {
            this.reassembleLists(res.list);

            for (var i = 0; i < res.list.length; i++) {
                if (this.clearBefore && res.list[i].data && res.list[i].data.length) {
                    this.empty(i);
                    this.lists[i].scrollbar.scrollToY(0);
                }
                if (res.list[i].data) {
                    this.offsets[i] = res.list[i].offset;
                    this.hasNext[i] = res.list[i].hasNext;
                    this.renderList(res.list[i].data, i);
                }
            }
        }
        this.loadLock = false;
    },
    onSaveSuccess: function () {
        this.saveLocks = false;
        this.managedItemIds = [{}, {}];
        this.lists.eq(0).find('.managed-list-item').data('srcListIdx', 0);
        this.lists.eq(1).find('.managed-list-item').data('srcListIdx', 1);
        if (this.closeOnSave) {
            this.close();
        }
    },
    renderItem: function (data, listIndex) {
        return $('<li class="managed-list-item">'+data+'<i class="icn icn-gray icn-close"></i><i class="icn icn-gray icn-plus"></i></li>');
    },
    renderList: function (list, listIndex) {
        if (!list.length && this.offsets[listIndex] == 0 && !this.filter) {
            this.addEmptyMessage(listIndex);
        } else if (list.length) {
            this.removeEmptyMessage(listIndex);
        }
        for (var i = 0, l = list.length, item; i < l; i++) {
            item = this.renderItem(list[i], listIndex).data({
                'itemId': this.getDataId(list[i]),
                'srcListIdx': listIndex,
                'listIdx': listIndex
            }).appendTo(this.lists.eq(listIndex));
        }
        this.lists[listIndex].scrollbar.update(false, true);
    },
    addEmptyMessage: function (listIndex) {
        if (!this.lists[listIndex].emptyMessage) {
            this.lists[listIndex].emptyMessage = $('<li class="managed-list-empty-item">'+this.emptyMessages[listIndex]+'</li>').appendTo(this.lists[listIndex]);
        }
    },
    removeEmptyMessage: function (listIndex) {
        if (this.lists[listIndex].emptyMessage) {
            this.lists[listIndex].emptyMessage.remove();
            this.lists[listIndex].emptyMessage = null;
        }
    },
    swap: function (item) {
        var data = item.data(),
            listIdx = data.listIdx,
            oppositeListIdx = (listIdx + 1) % 2,
            swappedFromSource = (data.srcListIdx == listIdx);

        item.detach().prependTo(this.lists.eq(oppositeListIdx));
        this.removeEmptyMessage(oppositeListIdx);
        if (!this.lists.eq(listIdx).find('.managed-list-item').length) {
            this.addEmptyMessage(listIdx);
        }
        data.listIdx = oppositeListIdx;
        this.lists[listIdx].scrollbar.update(false, true);
        this.lists[oppositeListIdx].scrollbar.update(false, true);
        if (swappedFromSource) {
            this.managedItemIds[oppositeListIdx][data.itemId] = true;
        } else {
            delete this.managedItemIds[listIdx][data.itemId];
        }
    },
    getDataId: function (data) {
        return data;//.id;
    },
    save: function () {
        if (this.saveLocks) return;
        this.saveLocks = true;
        if (!this.isChanged()) return this.onSaveSuccess();
        fs.post(this.saveAjaxUrl, this.saveAjaxParams(), this._onAjaxSaveSuccess);
    },
    onOpen: function (popup) {
        this.popup = popup;
        popup.popupBody.find('.popup-footer .btn-save').click(this._onSaveClick);
    },
    onClose: function (popup) {
        this.popup = null;
    }
};

/*
 * Попап для управления списками людей
 */
var peopleManagePopup = function (opts) {
    var popup = new listManagePopup($.extend({
        title: 'Выберите людей',
        inputPlaceholder: 'Начните вводить имя или фамилию',
        myclass: 'list-manage-popup people-manage-popup',
        listTitles: ['Все люди', 'Выбранные люди'],
        width: 620,
        loadAjaxUrl: '',
        saveAjaxUrl: '',
        renderItem: function (data) {
            return $('<li class="managed-list-item"><div class="friend-avatar"><img src="'+data.image+'"/></div><span class="friend-name ellipsis">'+data.name+'</span><i class="icn icn-gray icn-close"></i><i class="icn icn-gray icn-plus"></i></li>');
        },
        getDataId: function (data) {
            return data.id;
        },
        flySearch: true
    }, opts));
    popup.open();
    return popup;
};

var contextNav = {};
(function(cn) {
    /**
     * go back button
     */
    var buttonRenders = {
            profileRender : function(html){
                var navTabs = $('#context-nav-tabs');
                if (!navTabs.length) {
                    navTabs = $('<div id="context-nav-tabs" class="nclear"></div>').prependTo('#content-inner');
                }
                navTabs.find('.contextNav-profileRender').remove();
                this.elem = $('<span class="tab-name menu-link ellipsis contextNav-profileRender" onclick="contextNav.clickStats({from: \'profile\', url: \''+this.url+'\'}); contextNav.clear(\''+this.name+'\'); nav2.go(\''+this.url+'\', false, { back: true });"><i class="icn icn-gray icn-left"></i>'+this.html+'</span>').appendTo(navTabs);
            },
            pacmanRender: function(html){
                var navTabs = $('#context-nav-tabs');
                if (!navTabs.length) {
                    navTabs = $('<div id="context-nav-tabs" class="nclear"></div>').prependTo('#content-inner');
                }
                navTabs.find('.contextNav-pacmanRender').remove();
                this.elem = $('<span class="tab-name menu-link ellipsis contextNav-pacmanRender" onclick="contextNav.clickStats({from: \'pacman\', url: \''+this.url+'\'}); contextNav.clear(\''+this.name+'\'); nav2.go(\''+this.url+'\', false, { back: true });"><i class="icn icn-gray icn-left"></i>'+this.html+'</span>').appendTo(navTabs);
            },
            defaultRender : function(html){
                console.log('default attach button render');
                var navTabs = $('#context-nav-tabs');
                if (!navTabs.length) {
                    navTabs = $('<div id="context-nav-tabs" class="nclear"></div>').prependTo('#content-inner');
                }
                navTabs.find('.contextNav-defaultRender').remove();
                this.elem = $('<span class="tab-name menu-link ellipsis contextNav-defaultRender" onclick="contextNav.clickStats({url: \''+this.url+'\'}); contextNav.clear(\''+this.name+'\'); nav2.go(\''+this.url+'\', false, { back: true });"><i class="icn icn-gray icn-left"></i>'+this.html+'</span>').appendTo(navTabs);
            }
        },
        buttonRenderKeys = {
            '/^\\/user\\/\\d+\\/$/': buttonRenders.profileRender,
            '/^\\/user\\/\\d+\\/(friends|blog|info)\\/$/': buttonRenders.profileRender,
            '/^\\/user\\/\\d+\\/albums\\/$/': buttonRenders.profileRender,
            '/^\\/user\\/\\d+\\/giftroom\\/$/': buttonRenders.profileRender,
            '/^\\/user\\/\\d+\\/album\\/\\d+\\/((photos|settings|comments)\\/)?(\\d+\\/)?$/': buttonRenders.profileRender,
            '/^\\/user\\/\\d+\\/board\\/\\d+\\/$/': buttonRenders.profileRender,
            '/^\\/\\d+\\/$/': buttonRenders.profileRender,
            '/^\\/u\\/[a-z\\d-]+\\/$/i': buttonRenders.profileRender,

            '/^\\/pacman\\/news\\//': buttonRenders.pacmanRender,
            '/^\\/play\\/feed\\/board\\//i': buttonRenders.pacmanRender
        },
        regExpGroups= {
            profile: [
                /^\/user\/\d+\/$/,
                /^\/\d+\/$/,
                /^\/u\/[a-z\d-]+\/$/i
            ],
            profilePages: [
                /^\/user\/\d+\/(friends|blog|info)\/$/,
                /^\/user\/\d+\/albums\/$/,
                /^\/user\/\d+\/giftroom\/$/,
                /^\/user\/\d+\/album\/\d+\/((photos|settings|comments)\/)?(\d+\/)?$/,
                /^\/user\/\d+\/board\/\d+\/$/
            ],
            pacmanNews: [ /^\/pacman\/news\// ],
            ny2014: [ /^\/holiday\/ny2014\// ],
            playfeed: [
                /^\/play\/feed\/board\//i
            ]
        };


    $.extend(cn, {
        cache : {},
        isInited: false,
        initLater: false,
        stack: [],
        ssCache : {},
        newButton: function(name, opts){
            if(!cn.isInited){
                if(!cn.initLater)
                    cn.initLater = [];
                cn.initLater.push({name: name, opts: opts});
                return true;
            }
            var item = $.extend({
                name: name,
                html: '',
                url: false,
                contexts: [],
                maxDuplicates: 1,
                preserveUponReload: false,
                attach: cn.attach,
                detach: cn.detach,
                destroy: cn.destroy
            }, opts);

            cn.pushToStack(item);

            nav2.eventer.on('setParam.cn'+item.name, function(event, data){
                cn.updateSavedUrl.call(item, data.url);
                if (item.preserveUponReload) {
                    cn.saveToSessionStorage(item.name, opts);
                }
            });
            if (item.preserveUponReload) {
                cn.saveToSessionStorage(item.name, opts);
            }

            if(typeof item.contexts === 'string')
                cn.convertContextToArray.call(item);
        },
        pushToStack: function(item){
            if (cn.cache[item.name]) {
                if(cn.cache[cn.stack[cn.stack.length-1]].url == item.url){
                    cn.clear(cn.stack[cn.stack.length-1]);
                    cn.pushToStack(item);
                } else {
                    if(item.maxDuplicates > 1){
                        for(var i=1, pushOk=false; i<item.maxDuplicates; i++){
                            if(!cn.cache[item.name+'##'+i]){
                                item.name += '##'+i;
                                cn.cache[item.name] = item;
                                cn.stack.push(item.name);
                                pushOk = true;
                                break;
                            }
                        }
                        if(!pushOk){
                            cn.removeDuplicate(item, cn.pushToStack);
                        }
                    } else {
                        cn.removeDuplicate(item, cn.pushToStack);
                    }
                }
            } else {
                cn.cache[item.name] = item;
                cn.stack.push(item.name);
            }
        },
        removeDuplicate: function(item, callback){
            for(var i=0; i<cn.stack.length; i++){
                if(cn.stack[i] == item.name){
                    for(var j=i; j<cn.stack.length; j++){
                        if(cn.stack[j] != item.name+'##'+1){
                            cn.destroy.call(cn.cache[cn.stack[j]]);
                            j--;
                        } else {
                            break;
                        }
                    }
                    break;
                }
            }
            cn.updateIndexes();
            if(typeof callback === 'function'){ callback(item); }
        },
        initFromArray: function(){
            for(var button in cn.initLater){
                cn.newButton(cn.initLater[button].name, cn.initLater[button].opts);
            }
            cn.initLater = false;
        },
        updateIndexes: function(){
            for(var i in cn.stack){
                var oldKey = cn.stack[i],
                    index = oldKey.split('##'),
                    key = index[0],
                    newKey;
                index = index[1];

                if(typeof index !== 'undefined'){
                    newKey = key + (index>1 ? '##'+parseInt(index-1) : '');
                    if(typeof cn.cache[newKey] === 'undefined'){
                        cn.stack[i] = newKey;
                        cn.cache[newKey] = cn.cache[oldKey];
                        cn.cache[newKey].name = newKey;
                        delete cn.cache[oldKey];
                        cn.ssCache[newKey] = cn.ssCache[oldKey];
                        delete cn.ssCache[oldKey];
                    }
                }
            }
            ss.set('contextNav', cn.ssCache);
            ss.set('contextNavStack', cn.stack);
        },
        refresh : function (location) {
            var navItem;
            location = location || nav2.location;

            for (var i = cn.stack.length - 1; i >= 0; i--) {
                navItem = cn.cache[cn.stack[i]];
                var context = cn.check.call(navItem, location.pathname);
                if (context) {
                    cn.attach.call(navItem, context);
                    break;
                }
            }
            nav2.gc(cn.gc, 'contextNav');
        },
        check : function (url) {
            if(url == (this.baseUrl || this.url))
                return false;
            for (var i = 0, l = this.contexts.length, context; i < l ; i++) {
                context = this.contexts[i];
                if (context instanceof RegExp) {
                    if(context.test(url)){
                        return context;
                    }
                }
            }
            return false;
        },
        attach : function (context) {
            context = context.toString();
            if(typeof buttonRenderKeys[context] === 'function'){
                buttonRenderKeys[context].call(this);
            } else {
                buttonRenders.defaultRender.call(this);
            }
        },
        detach : function () {
            /* no real need to detach element, it will be removed on navigation
            if (this.elem) {
                this.elem.remove();
                this.elem = null;
            }*/
            return true;
        },
        destroy : function () {
            cn.detach.call(this);
            for(var i = cn.stack.length-1; i>=0; i--){
                if(cn.stack[i] == this.name){
                    cn.stack.splice(i,1);
                    break;
                }
            }
            delete cn.cache[this.name];
            cn.removeFromSessionStorage(this.name);
        },
        clear: function(name){
            cn.initLater = false;
            if(typeof name === 'undefined'){
                for(var i in cn.stack){
                    cn.detach.call(cn.cache[cn.stack[i]]);
                }
                cn.cache = {};
                cn.stack = [];
                cn.ssCache = {};
            } else if(name == 'this_url') {
                cn.destroy.call(cn.cache[cn.stack[cn.stack.length - 1]]);
            } else if(cn.cache[name]) {
                for(var i = cn.stack.length-1; i>=0; i--){
                    if(cn.stack[i] == name){
                        cn.destroy.call(cn.cache[cn.stack[i]]);
                        break;
                    } else {
                        cn.destroy.call(cn.cache[cn.stack[i]]);
                    }
                }
            }
            ss.set('contextNav', cn.ssCache);
            ss.set('contextNavStack', cn.stack);
        },
        updateSavedUrl: function(url){
            this.baseUrl = this.baseUrl || this.url;
            this.url = url;
        },
        convertContextToArray: function(){
            var contexts = this.contexts.split(',');
            this.contexts = [];
            for(var i in contexts){
                if(typeof regExpGroups[contexts[i]] !== 'undefined')
                    this.contexts = this.contexts.concat(regExpGroups[contexts[i]]);
            }
        },
        saveToSessionStorage : function (name, opts) {
            cn.ssCache[name] = opts;
            ss.set('contextNav', cn.ssCache);
            ss.set('contextNavStack', cn.stack);
        },
        removeFromSessionStorage : function (name) {
            delete cn.ssCache[name];
            ss.set('contextNav', cn.ssCache);
            ss.set('contextNavStack', cn.stack);
        },
        loadFromSessionStorage : function () {
            cn.isInited = true;
            var cache = ss.get('contextNav'),
                stack = ss.get('contextNavStack'),
                name;
            if(!stack)
                return false;
            for (var j=0; j < stack.length; j++) {
                name = stack[j];
                cn.newButton(name.split('##')[0], cache[name]);
            }
            if(cn.initLater){
                cn.initFromArray();
            }
        },
        clickStats: function(params) {
          $.post('/fast/contextnav.php', params);
        },
        gc : function () {
            var context,
                navItem,
                location = location || nav2.location,
                name;
            for(var i = cn.stack.length - 1; i >= 0; i--){
                name = cn.stack[i];
                navItem = cn.cache[name];

                nav2.eventer.off('setParam.cn'+name);
                if (cn.check.call(navItem, location.pathname)) {
                    cn.detach.call(navItem);
                    break;
                } else {
                    cn.destroy.call(navItem);
                }
            }
        }
    });

    $(function(){
        cn.loadFromSessionStorage();
        cn.refresh();
    });
})(contextNav);

// Прилипающая к верху экрана панель
var floatingPanel = function (opts) {
    $.extend(this, {
        wrap: null,
        floatingElem: null,
        floatClass: 'fp-is-floating',
        startFloatOffset: 0,
        stopFloatOffset: 0,
        onStartFloat: null,
        onStopFloat: null,
        enabled: true
    }, opts);
    this.init();
};
floatingPanel.cache = [];
floatingPanel.gc = function () {
    floatingPanel.cache = [];
    $(window).unbind('scroll', floatingPanel.scrollHandlerFn);
    floatingPanel.scrollHandlerBinded = false;
};
floatingPanel.scrollHandlerTimeout = null;
floatingPanel.scrollHandlerFn = function () {
    clearTimeout(floatingPanel.scrollHandlerTimeout);
    floatingPanel.scrollHandlerTimeout = setTimeout(floatingPanel.scrollHandlerTimeoutCallback, 0);
};
floatingPanel.scrollHandlerTimeoutCallback = function () {
    floatingPanel.windowScrollTop = $(window).scrollTop();
    floatingPanel.windowScrollLeft = $(window).scrollLeft();
    for (var i = 0, l = floatingPanel.cache.length; i < l; i++) {
        floatingPanel.cache[i].scrollHandler();
    }
};
floatingPanel.scrollHandlerBinded = false;
floatingPanel.prototype = {
    init: function () {
        if (this.inited) return;
        var me = this;

        this.inited = false;
        this.floating = false;

        floatingPanel.cache.push(this);

        this.wrap = $(this.wrap);
        this.floatingElem = $(this.floatingElem);

        if (!floatingPanel.scrollHandlerBinded) {
            $(window).bind('scroll', floatingPanel.scrollHandlerFn);
            floatingPanel.scrollHandlerBinded = true;
            floatingPanel.scrollHandlerFn();
        }

        nav2.gc(floatingPanel.gc, 'floatingPanel');

        this.inited = true;
    },
    scrollHandler: function () {
        if (!this.enabled) return;
        if (this.floating && this.wrap.offset().top >= floatingPanel.windowScrollTop + this.stopFloatOffset) {
            this.stopFloat();
        } else if (!this.floating && this.wrap.offset().top < floatingPanel.windowScrollTop + this.startFloatOffset) {
            this.startFloat();
        }
        if (this.onScroll) {
            this.onScroll();
        }
    },
    startFloat: function () {
        if (this.floating) return;

        this.wrap.css({
            width: this.wrap.width(),
            height: this.wrap.height()
        });

        this.floatingElem.css({
            'position': 'fixed'
        }).addClass(this.floatClass);
        this.floating = true;
        if (this.onStartFloat) {
            this.onStartFloat();
        }
    },
    stopFloat: function () {
        if (!this.floating) return;

        this.wrap.css({
            width: '',
            height: ''
        });

        this.floatingElem.css({
            'position': ''
        }).removeClass(this.floatClass);
        this.floating = false;
        if (this.onStopFloat) {
            this.onStopFloat();
        }
    },
    destroy: function () {
        if (!this.inited) return;

        var cacheIndex = floatingPanel.cache.indexOf(this);
        if (cacheIndex != -1) {
            floatingPanel.cache.splice(cacheIndex, 1);
        }

        this.wrap = null;
        this.floatingElem = null;

        this.inited = false;
    }
};

// обретка для fsSelect, позволяющая ему "плавать" за панелью
var fsSelectFloating = function (floatingPanel, fsSelectOpts) {
    nav2.gc(fsSelectFloating.gc, 'fsSelectFloating');
    return new fsSelect($.extend({
        showFinder: function () {
            var self = this;

            fsSelectFloating.lastOpened = self;

            if(fsSelect.current == self.element) {return;}
            if(self.disabled) {return;}
            else {
                $(document)
                    .unbind('click', fsSelect.hideFinder)
                    .bind('click', fsSelect.hideFinder);
                var offsetPosition = self.wrapper.offset(),
                    headerHeight = self.header.outerHeight(),
                    headerWidth = self.header.outerWidth();

                fsSelect.current = self.element;
                self.wrapper.addClass('opened');
                self.finderBox = $("#form-selector-box");
                if(self.finderBox.length == 0) self.finderBox = $('<div>', {'id' :'form-selector-box', 'onclick' : "sp(event)"}).appendTo("#node-heap");

                self.finderBox.css({
                    'left' : offsetPosition.left,
                    'top' : offsetPosition.top + headerHeight - 1,
                    'width' : headerWidth - 2,
                    'display': 'block',
                    'z-index': (self.selectIndex ? self.selectIndex : 2)
                }).html("");

                var html = self.render(self.array);
                self.finderBox.html(html);

                var selected = self.finderBox.find('.selected');
                self.finderBox.scrollTop(selected.length ? self.finderBox.scrollTop() + selected.position().top : 0);
            }

            if (($.isFunction(floatingPanel) ? floatingPanel() : floatingPanel).floating) {
                self.startFloat();
            }
        },
        startFloat: function () {
            if(this.finderBox) {
                this.finderBox.css({
                    position: 'fixed',
                    top: this.wrapper.offset().top + this.header.outerHeight() - 1 - (($.isFunction(floatingPanel) ? floatingPanel() : floatingPanel) instanceof window.floatingPanel ? window.floatingPanel.windowScrollTop : fs.scrollTop)
                });
            }
        },
        stopFloat: function () {
            if(this.finderBox) {
                this.finderBox.css({
                    position: '',
                    top: this.wrapper.offset().top + this.header.outerHeight() - 1
                });
            }
        }
    }, fsSelectOpts));
};
fsSelectFloating.lastOpened = null;
fsSelectFloating.gc = function () {
    fsSelectFloating.lastOpened = null;
};

(function($) {
	$.fn.timer = function(seconds, options) {
		var settings = $.extend({
			callback: ""
			//format:
		}, options),
        style = ['visible','hidden']; // костыль для хрома
		/* ToDo:
			1. клерить $.fn.timer.interval если $.fn.timer.objs пустой
			3. добавить проверки на андефайнеты и прочие возможные ошибки
            5. Разобраться с костылем для хрома
		*/
		if(!$.fn.timer.interval) {
			$.fn.timer.objs = [];
			var handler = function() {
				for(var i = 0; i < $.fn.timer.objs.length; i++) {
					if($.fn.timer.objs[i] && $.fn.timer.objs[i][1] >= 0) {
						if($.isFunction($.fn.timer.objs[i][2].format)) {
							$($.fn.timer.objs[i][0]).html($.fn.timer.objs[i][2].format($.fn.timer.objs[i][1]));
						} else {
							$($.fn.timer.objs[i][0]).html(timeSmall($.fn.timer.objs[i][1], true));
						}
                        if($.isFunction($.fn.timer.objs[i][2].step)) {
                            $.fn.timer.objs[i][2].step($($.fn.timer.objs[i][0]));
                        }
                        if ($.browser.webkit) { // тоже костыль для хрома
                            $($.fn.timer.objs[i][0]).css('overflow',style[$.fn.timer.objs[i][1] % 2]);
                        }
						$.fn.timer.objs[i][1]--;
					} else {
						if($.isFunction($.fn.timer.objs[i][2].callback)) {
							$.fn.timer.objs[i][2].callback($($.fn.timer.objs[i][0]));
						}
						$.fn.timer.objs.splice(i, 1);
						i--;
					}
				}
			};
            handler();
			$.fn.timer.interval = setInterval(handler, 1000);
		}
		return this.each(function() {
			$.fn.timer.objs.push([this, seconds, settings]);
		});
	};
})(jQuery);


try{staticManager.done('js_fs2_js')}catch(e){}
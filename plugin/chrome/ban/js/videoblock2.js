var whitelist=[/(\/\/|\.)analytics\.163\.com\/ntes\.js/,/(\/\/|\.)static\.atm\.youku\.com.*\.swf/,/(\/\/|\.)valf\.atm\.youku\.com\/crossdomain\.xml/,/(\/\/|\.)js\.tudouui\.com\/bin\/player/];whitelist.push(/(\/\/|\.)valf\.atm\.youku\.com\/valf\?/),whitelist.push(/\/\/td\.atm\.youku\.com\/crossdomain\.xml/);var blacklist=[/\/\/secure\.gaug\.es/,/\/\/stat\.ku6\.com/,/\/\/gug\.ku6cdn\.com/,/\/\/.*\.snyu\.com/,/\/\/dcads\.sina\.com\.cn/,/\/\/v\.cctv\.com\/flash\/vd\//,/(\/\/|\.)log\.vdn\.apps\.cntv\.cn/,/\/\/d\.cntv\.cn\/crossdomain\.xml/,/(\/\/|\.)acs86\.com/,/\/\/86file\.megajoy\.com/,/(\/\/|\.)ugcad\.pps\.tv/,/(\/\/|\.)stat\.ppstream\.com/,/(\/\/|\.)player\.pplive\.cn.*\/PPLivePlugin\.swf/,/(\/\/|\.)mat1\.gtimg\.com\/health\/ad\//,/(\/\/|\.)mat1\.gtimg\.com\/sports\/.*ad/,/\/\/adslvfile\.qq\.com/,/(\/\/|\.)56\.com\/cfstat/,/(\/\/|\.)56\.com\/flashApp\/ctrl_ui_site\/pause_ad_panel\//,/(\/\/|\.)56\.com\/js\/promo\//,/(\/\/|\.)stat\.56\.com/,/(\/\/|\.)v-56\.com/,/\/\/acs\.56/,/(\/\/|\.)letv\.allyes\.com/,/(\/\/|\.)dc\.letv\.com/,/(\/\/|\.)pro\.hoye\.letv\.com/,/(\/\/|\.)js\.letvcdn\.com\/js\/.*\/stats\//,/(\/\/|\.)player\.letvcdn\.com\/p\/.*\/pb\/pbTip\.swf/,/(\/\/|\.)img1\.126\.net/,/(\/\/|\.)img2\.126\.net/,/(\/\/|\.)stat\.ws\.126\.net/,/(\/\/|\.)adgeo\.163\.com/,/(\/\/|\.)g\.163\.com\/.*&affiliate=/,/(\/\/|\.)popme\.163\.com/,/(\/\/|\.)ifengimg\.com\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\.swf/,/(\/\/|\.)games\.ifeng\.com\/webgame\//,/(\/\/|\.)img\.ifeng\.com\/tres\/html\//,/(\/\/|\.)img\.ifeng\.com\/tres\/ifeng\//,/(\/\/|\.)img\.ifeng\.com\/tres\/market\//,/(\/\/|\.)play\.ifeng\.com\/resource_new\/js\/playbox\.js/,/(\/\/|\.)sta\.ifeng\.com/,/(\/\/|\.)stadig\.ifeng\.com/,/(\/\/|\.)ifengimg\.com\/ifeng\/ad\//,/(\/\/|\.)ifengimg\.com\/ifeng\/sources\//,/(\/\/|\.)ifengimg\.com\/mappa\//,/\/\/w\.cnzz\.com\/c\.php/,/(\/\/|\.)qq\.com\/livemsg\?/,/(\/\/|\.)kankanews\.com.*\/gs\.js/,/(\/\/|\.)kankanews\.com\/flash\/PreAdLoader\.swf/,/(\/\/|\.)vd\.kankanews\.com/];blacklist.push(/\/\/xiu\.56\.com\/xapi\/offsite_swf_more\.php\?ver=4/),blacklist.push(/(\/\/|\.)itc\.cn.*\/tracker\.js/,/(\/\/|\.)txt\.go\.sohu\.com\/ip\/soip/,/(\/\/|\.)xls\.go\.sohu\.com/,/(\/\/|\.)images\.sohu\.com\/bill\//,/(\/\/|\.)images\.sohu\.com\/cs\//,/(\/\/|\.)js\.sohu\.com\/track\//,/(\/\/|\.)js\.sohu\.com\/wrating0820\.js/,/(\/\/|\.)news\.sohu\.com\/upload\/article\/2012\/images\/swf\//,/(\/\/|\.)z\.t\.sohu\.com/,/(\/\/|\.)imp\.go\.sohu\.com/,/(\/\/|\.)images\.sohu\.com\/ytv\//,/(\/\/|\.)mfiles\.sohu\.com\/tv\/csad\//,/(\/\/|\.)tv\.sohu\.com\/upload\/static\/global\/hdpv\.js/,/(\/\/|\.)tv\.sohu\.com\/upload\/trace\//,/(\/\/|\.)p\.aty\.sohu\.com/,/(\/\/|\.)vm\.aty\.sohu\.com/,/(\/\/|\.)v\.blog\.sohu\.com\/dostat\.do\?/,/(\/\/|\.)his\.tv\.sohu\.com\/his\/ping\.do\?/,/(\/\/|\.)count\.vrs\.sohu\.com/,/(\/\/|\.)data\.vrs\.sohu\.com\/player\.gif?/,/(\/\/|\.)hd\.sohu\.com\.cn/),blacklist.push(/(\/\/|\.)resource\.redirect\.kukuplay\.com\/upload\/fyad5\.flv/),blacklist.push(/(\/\/|\.)cb\.baidu\.com/),blacklist.push(/(\/\/|\.)cbjs\.baidu\.com/),blacklist.push(/(\/\/|\.)cpro\.baidu\.com/),blacklist.push(/(\/\/|\.)drmcmm\.baidu\.com/),blacklist.push(/(\/\/|\.)duiwai\.baidu\.com/),blacklist.push(/(\/\/|\.)eclick\.baidu\.com/),blacklist.push(/(\/\/|\.)eiv\.baidu\.com/),blacklist.push(/(\/\/|\.)nsclick\.baidu\.com/),blacklist.push(/(\/\/|\.)sclick\.baidu\.com/),blacklist.push(/(\/\/|\.)spcode\.baidu\.com/),blacklist.push(/(\/\/|\.)tudou\.com.*\/outside\.php/),blacklist.push(/(\/\/|\.)player\.pb\.ops\.tudou\.com\/info\.php\?/),blacklist.push(/(\/\/|\.)stat.*\.tudou\.com/),blacklist.push(/\/\/js\.tudouui\.com\/bin\/lingtong\/.*\.jpg/),blacklist.push(/(\/\/|\.)l\.ykimg\.com/),blacklist.push(/(\/\/|\.)p-log\.ykimg\.com/),blacklist.push(/(\/\/|\.)e\.stat\.ykimg\.com\/red\//),blacklist.push(/(\/\/|\.)atm\.youku\.com/),blacklist.push(/(\/\/|\.)hz\.youku\.com\/red\//),blacklist.push(/(\/\/|\.)lstat\.youku\.com/),blacklist.push(/(\/\/|\.)e\.stat\.youku\.com/),blacklist.push(/(\/\/|\.)l\.youku\.com.*log\?/),blacklist.push(/(\/\/|\.)t\.stat\.youku\.com/),blacklist.push(/(\/\/|\.)static\.youku\.com\/.*\/js\/cps\.js/),blacklist.push(/(\/\/|\.)static\.youku\.com\/.*\/index\/js\/hzClick\.js/),blacklist.push(/(\/\/|\.)static\.youku\.com\/.*\/index\/js\/iresearch\.js/),blacklist.push(/(\/\/|\.)msg\.iqiyi\.com/),blacklist.push(/(\/\/|\.)afp\.qiyi\.com/),blacklist.push(/(\/\/|\.)static\.qiyi\.com\/js\/pingback\//),blacklist.push(/(\/\/|\.)jsmsg\.video\.qiyi\.com/),blacklist.push(/(\/\/|\.)msg\.video\.qiyi\.com/),blacklist.push(/(\/\/|\.)uestat\.video\.qiyi\.com/);var yk1="http://lovejiani.duapp.com/opengg/player_ss.swf",yk2="http://haoutil.googlecode.com/svn/trunk/youku/player.swf",yk3="http://player.opengg.me/player.swf",ykext="?showAd=0&VideoIDS=$2",yk4="http://git.oschina.net/kawaiiushio/antiad/raw/master/loader.swf";void 0==localStorage.ykplayer&&(localStorage.ykplayer=yk4);var redirectlist=[{name:"\u66ff\u6362\u4f18\u9177\u64ad\u653e\u5668",find:/^http:\/\/static\.youku\.com\/.*?q?(player|loader)(_[^.]+)?\.swf/,replace:localStorage.ykplayer,extra:"adkillrule"},{name:"\u66ff\u6362\u4f18\u9177\u5916\u94fe\u64ad\u653e\u5668",find:/^http:\/\/player\.youku\.com\/player\.php\/(.*\/)?sid\/([\w=]+)\/v\.swf/,replace:localStorage.ykplayer+ykext,extra:"adkillrule"},{name:"\u66ff\u6362ku6\u64ad\u653e\u5668",find:/^http:\/\/player\.ku6cdn\.com\/default\/common\/player\/\d*\/player\.swf/,replace:"http://lovejiani.duapp.com/antiad/ku6.swf",extra:"adkillrule"},{name:"qy\u91cd\u5b9a\u5411",find:/^http:\/\/www\.iqiyi\.com\/player\/[a-z0-9]{7,}\.swf/,replace:"http://www.iqiyi.com/player/vrs/20120620132333/1cc81e80-74ba-45f0-8a44-928268bab799.swf",extra:"adkillrule2"},{name:"td\u91cd\u5b9a\u5411",find:/^http:\/\/td\.atm\.youku\.com\/tdcm\/adcontrol/,replace:"http://www.tudou.com/util/tools/www_hd.txt",extra:"adkillrule2"},{name:"letv\u91cd\u5b9a\u5411",find:/^http:\/\/player\.letvcdn\.com\/p\/.*\/newplayer\/.*\/ALetvPlayer\.swf/,replace:"about:blank",extra:"adkillrule2"}],whitetab=[],blockurls=[],mediaurls=[];chrome.webRequest.onBeforeRequest.addListener(function(a){if("true"==localStorage.videoAdkill){var b=a.url,c="tabid"+a.tabId,d=a.type;if(-1!=a.tabId&&!whitetab[c]){for(var e=0;e<redirectlist.length;e++){var f=redirectlist[e].extra;if(("adkillrule"!=f&&"adkillrule2"!=f||localStorage.videoAdkill)&&("adkillrule2"!=f||"main_frame"!=d)&&redirectlist[e].find.test(b)){var g=b.replace(redirectlist[e].find,redirectlist[e].replace);return g=decodeURIComponent(g),{redirectUrl:g}}}if(localStorage.videoAdkill&&"main_frame"!=d){for(var e=0;e<whitelist.length;e++)if(whitelist[e].test(b))return;for(var e=0;e<blacklist.length;e++)if(blacklist[e].test(b))return void 0==blockurls[c]&&(blockurls[c]=[]),-1==blockurls[c].indexOf(b)&&blockurls[c].push(b),"sub_frame"==d?{redirectUrl:"about:blank"}:{cancel:!0};return{cancel:!1}}}}},{urls:["http://*/*","https://*/*"]},["blocking"]),void 0==localStorage.videoAdkill&&(localStorage.videoAdkill=!0);
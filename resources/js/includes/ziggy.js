    var Ziggy = {
        namedRoutes: {"posts.index":{"uri":"api","methods":["GET","HEAD"],"domain":null},"posts.show":{"uri":"api\/{post}","methods":["GET","HEAD"],"domain":null},"posts.store":{"uri":"api","methods":["POST"],"domain":null},"post-comments.index":{"uri":"api\/{post}\/comments","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'http://localhost/',
        baseProtocol: 'http',
        baseDomain: 'localhost',
        basePort: false,
        defaultParameters: []
    };

    if (typeof window.Ziggy !== 'undefined') {
        for (var name in window.Ziggy.namedRoutes) {
            Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
        }
    }

    export {
        Ziggy
    }

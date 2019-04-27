    var Ziggy = {
        namedRoutes: {"login":{"uri":"api\/auth\/login","methods":["POST"],"domain":null},"products.show":{"uri":"api\/auth\/products","methods":["GET","HEAD"],"domain":null},"products.create":{"uri":"api\/auth\/auth\/products\/store","methods":["POST"],"domain":null},"products.delete":{"uri":"api\/auth\/auth\/products\/destroy","methods":["DELETE"],"domain":null},"products.update":{"uri":"api\/auth\/auth\/products\/update","methods":["PUT"],"domain":null}},
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

    var Ziggy = {
        namedRoutes: {"product.product.index":{"uri":"api","methods":["GET","HEAD"],"domain":null},"product.product.show":{"uri":"api\/{id}","methods":["GET","HEAD"],"domain":null},"product.product.create":{"uri":"api","methods":["POST"],"domain":null},"product.product.delete":{"uri":"api\/{id}","methods":["DELETE"],"domain":null}},
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

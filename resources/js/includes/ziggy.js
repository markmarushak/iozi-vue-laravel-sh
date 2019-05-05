    var Ziggy = {
        namedRoutes: {"login":{"uri":"api\/auth\/login","methods":["POST"],"domain":null},"products.show":{"uri":"api\/auth\/products","methods":["GET","HEAD"],"domain":null},"products.store":{"uri":"api\/auth\/products","methods":["POST"],"domain":null},"products.delete":{"uri":"api\/auth\/products\/{id}","methods":["DELETE"],"domain":null},"products.update":{"uri":"api\/auth\/products","methods":["PUT"],"domain":null},"attribute.index":{"uri":"api\/auth\/products\/product-attribute","methods":["GET","HEAD"],"domain":null},"attribute.show":{"uri":"api\/auth\/products\/product-attribute\/{id}","methods":["GET","HEAD"],"domain":null},"attribute.store":{"uri":"api\/auth\/products\/product-attribute","methods":["POST"],"domain":null},"attribute.destroy":{"uri":"api\/auth\/products\/product-attribute\/{id}","methods":["DELETE"],"domain":null},"attribute.update":{"uri":"api\/auth\/products\/product-attribute","methods":["PUT"],"domain":null},"option.index":{"uri":"api\/auth\/products\/product-option","methods":["GET","HEAD"],"domain":null},"option.show":{"uri":"api\/auth\/products\/product-option\/{id}","methods":["GET","HEAD"],"domain":null},"option.store":{"uri":"api\/auth\/products\/product-option","methods":["POST"],"domain":null},"option.destroy":{"uri":"api\/auth\/products\/product-option\/{id}","methods":["DELETE"],"domain":null},"option.update":{"uri":"api\/auth\/products\/product-option","methods":["PUT"],"domain":null},"payment.show":{"uri":"api\/auth\/cabinet\/payment","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'http://learn.home/',
        baseProtocol: 'http',
        baseDomain: 'learn.home',
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

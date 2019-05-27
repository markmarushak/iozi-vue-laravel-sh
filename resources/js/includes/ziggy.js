    var Ziggy = {
        namedRoutes: {"login":{"uri":"api\/auth\/login","methods":["POST"],"domain":null},"products.index":{"uri":"api\/auth\/products","methods":["GET","HEAD"],"domain":null},"products.search":{"uri":"api\/auth\/search","methods":["POST"],"domain":null},"attribute.index":{"uri":"api\/auth\/attribute\/{type}","methods":["GET","HEAD"],"domain":null},"attribute.show":{"uri":"api\/auth\/attribute{id}","methods":["GET","HEAD"],"domain":null},"get.user":{"uri":"api\/auth\/get-user","methods":["GET","HEAD"],"domain":null},"products.store":{"uri":"api\/auth\/products","methods":["POST"],"domain":null},"products.image":{"uri":"api\/auth\/products\/image","methods":["POST"],"domain":null},"products.image.upload":{"uri":"api\/auth\/products\/image\/upload","methods":["POST"],"domain":null},"products.destroy":{"uri":"api\/auth\/products\/{id}","methods":["DELETE"],"domain":null},"products.update":{"uri":"api\/auth\/products","methods":["PUT"],"domain":null},"attribute.store":{"uri":"api\/auth\/product-attribute","methods":["POST"],"domain":null},"attribute.destroy":{"uri":"api\/auth\/product-attribute\/{id}","methods":["DELETE"],"domain":null},"attribute.update":{"uri":"api\/auth\/product-attribute","methods":["PUT"],"domain":null},"payment.show":{"uri":"api\/auth\/payment","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'http://v124285.hosted-by-vdsina.ru/',
        baseProtocol: 'http',
        baseDomain: 'v124285.hosted-by-vdsina.ru',
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

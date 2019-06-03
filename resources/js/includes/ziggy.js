    var Ziggy = {
        namedRoutes: {"get.user":{"uri":"api\/get-user","methods":["GET","HEAD"],"domain":null},"products.store":{"uri":"api\/products","methods":["POST"],"domain":null},"products.update":{"uri":"api\/products","methods":["PUT"],"domain":null},"products.cabinet":{"uri":"api\/products\/products","methods":["GET","HEAD"],"domain":null},"products.image":{"uri":"api\/products\/image","methods":["POST"],"domain":null},"products.image.upload":{"uri":"api\/products\/image\/upload","methods":["POST"],"domain":null},"products.confirm":{"uri":"api\/products\/confirm","methods":["POST"],"domain":null},"products.pay":{"uri":"api\/products\/pay","methods":["POST"],"domain":null},"products.confirm.list":{"uri":"api\/products\/confirm-list","methods":["GET","HEAD"],"domain":null},"products.destroy":{"uri":"api\/products\/{id}","methods":["DELETE"],"domain":null},"attribute.store":{"uri":"api\/product-attribute","methods":["POST"],"domain":null},"attribute.destroy":{"uri":"api\/product-attribute\/{id}","methods":["DELETE"],"domain":null},"attribute.update":{"uri":"api\/product-attribute","methods":["PUT"],"domain":null},"payment.show":{"uri":"api\/payment","methods":["GET","HEAD"],"domain":null},"login":{"uri":"api\/login","methods":["POST"],"domain":null},"register":{"uri":"api\/register","methods":["POST"],"domain":null},"logout":{"uri":"api\/logout","methods":["POST"],"domain":null},"home":{"uri":"api","methods":["GET","HEAD"],"domain":null},"products.index":{"uri":"api\/products","methods":["GET","HEAD"],"domain":null},"products.show":{"uri":"api\/products\/{id}","methods":["GET","HEAD"],"domain":null},"products.search":{"uri":"api\/search","methods":["POST"],"domain":null},"attribute.index":{"uri":"api\/attribute\/{type}","methods":["GET","HEAD"],"domain":null},"attribute.show":{"uri":"api\/attribute{id}","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'http://iozi.loc/',
        baseProtocol: 'http',
        baseDomain: 'iozi.loc',
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

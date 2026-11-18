(function () {
    function currentIndex(tabsRoot) {
        var tabs = tabsRoot.querySelectorAll('.cf-complex__tabs-list > .cf-complex__tabs-item');
        var current = 1;
        for (var i = 0; i < tabs.length; i++) {
            if (tabs[i].classList.contains('cf-complex__tabs-item--current')) {
                current = i + 1;
                break;
            }
        }
        return current;
    }

    function sync(field) {
        var tabsRoot = field.querySelector('.cf-complex__tabs--tabbed-horizontal, .cf-complex__tabs--tabbed-vertical');
        if (!tabsRoot) {
            return;
        }
        var next = String(currentIndex(tabsRoot));
        if (field.getAttribute('data-mastrade-tab') !== next) {
            field.setAttribute('data-mastrade-tab', next);
        }
    }

    function relaxSortable(field) {
        var $ = window.jQuery;
        if (!$ || !$.fn || !$.fn.sortable) {
            return;
        }
        field.querySelectorAll('.cf-complex__groups, .cf-complex__tabs-list').forEach(function (node) {
            var $node = $(node);
            if (!$node.data('ui-sortable')) {
                return;
            }
            $node.sortable('option', 'distance', 8);
            $node.sortable('option', 'cancel', 'input, textarea, button, select, option, a, .cf-file__inner, .cf-complex__group-action');
        });
    }

    function attach(field) {
        if (field.dataset.logoTabsBound) {
            sync(field);
            return;
        }
        field.dataset.logoTabsBound = '1';
        var tabsRoot = field.querySelector('.cf-complex__tabs--tabbed-horizontal, .cf-complex__tabs--tabbed-vertical');
        if (!tabsRoot) {
            return;
        }

        new MutationObserver(function () {
            sync(field);
        }).observe(tabsRoot, {
            subtree: true,
            childList: true,
            attributes: true,
            attributeFilter: ['class']
        });

        window.setTimeout(function () {
            relaxSortable(field);
            sync(field);
        }, 0);
    }

    function scan(doc) {
        if (!doc) {
            return;
        }
        doc.querySelectorAll('.cf-complex__tabs--tabbed-horizontal, .cf-complex__tabs--tabbed-vertical').forEach(function (tabs) {
            var field = tabs.closest('.cf-field');
            if (field) {
                attach(field);
            }
        });
    }

    function watch(doc) {
        if (!doc || !doc.body || doc.documentElement.dataset.logoTabsWatch) {
            return;
        }
        doc.documentElement.dataset.logoTabsWatch = '1';
        scan(doc);
        new MutationObserver(function () {
            scan(doc);
        }).observe(doc.body, {
            childList: true,
            subtree: true
        });
    }

    function boot() {
        var frames = document.querySelectorAll('iframe[name="editor-canvas"]');
        if (!frames.length) {
            watch(document);
            return;
        }
        frames.forEach(function (iframe) {
            var open = function () {
                watch(iframe.contentDocument);
            };
            if (!iframe.dataset.logoTabsBoot) {
                iframe.dataset.logoTabsBoot = '1';
                iframe.addEventListener('load', open);
            }
            open();
        });
    }

    var tries = 0;
    var timer = window.setInterval(function () {
        boot();
        tries += 1;
        if (tries > 20) {
            window.clearInterval(timer);
        }
    }, 500);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();

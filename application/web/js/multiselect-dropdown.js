/**
 * multiselect-dropdown.js
 * Minimal multiselect dropdown — transforms <select multiple> into a
 * checkbox-based dropdown. Auto-initialises on DOMContentLoaded.
 *
 * Class names used by existing JS (GzDonation.js, GzPujacart.js):
 *   .multiselect-dropdown   — outer wrapper
 *   .multiselect-input-div  — clickable label/trigger
 *   .multiselect-checkbox   — each option checkbox
 */
(function () {
    'use strict';

    function buildDropdown(select) {
        if (select.dataset.multiselectBuilt) return;
        select.dataset.multiselectBuilt = '1';
        select.style.display = 'none';

        var wrapper = document.createElement('div');
        wrapper.className = 'multiselect-dropdown';

        var trigger = document.createElement('div');
        trigger.className = 'multiselect-input-div';
        trigger.style.cssText = 'cursor:pointer;border:1px solid #ccc;padding:4px 8px;border-radius:4px;background:#fff;min-height:30px;';
        trigger.textContent = select.options.length ? 'Select...' : '—';

        var list = document.createElement('div');
        list.style.cssText = 'display:none;position:absolute;z-index:9999;background:#fff;border:1px solid #ccc;border-radius:4px;padding:4px;max-height:200px;overflow-y:auto;min-width:180px;';

        Array.prototype.forEach.call(select.options, function (opt) {
            var label = document.createElement('label');
            label.style.cssText = 'display:block;padding:2px 4px;cursor:pointer;white-space:nowrap;';

            var cb = document.createElement('input');
            cb.type = 'checkbox';
            cb.className = 'multiselect-checkbox';
            cb.value = opt.value;
            cb.checked = opt.selected;
            cb.style.marginRight = '6px';

            cb.addEventListener('change', function () {
                opt.selected = cb.checked;
                updateTrigger(select, trigger);
                // fire change on the original select so existing handlers work
                var ev = document.createEvent('Event');
                ev.initEvent('change', true, true);
                select.dispatchEvent(ev);
            });

            label.appendChild(cb);
            label.appendChild(document.createTextNode(opt.text));
            list.appendChild(label);
        });

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            list.style.display = list.style.display === 'none' ? 'block' : 'none';
        });

        document.addEventListener('click', function () {
            list.style.display = 'none';
        });

        wrapper.appendChild(trigger);
        wrapper.appendChild(list);
        select.parentNode.insertBefore(wrapper, select.nextSibling);
        updateTrigger(select, trigger);
    }

    function updateTrigger(select, trigger) {
        var selected = [];
        Array.prototype.forEach.call(select.options, function (opt) {
            if (opt.selected) selected.push(opt.text);
        });
        trigger.textContent = selected.length ? selected.join(', ') : 'Select...';
    }

    function init() {
        var selects = document.querySelectorAll('select[multiple]');
        Array.prototype.forEach.call(selects, function (sel) {
            buildDropdown(sel);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

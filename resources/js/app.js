import './bootstrap';

import {delegate} from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/animations/shift-toward-subtle.css';

delegate('body', {
    interactive: true,
    allowHTML: true,
    animation: 'shift-toward-subtle',
    target: '[data-tippy-content]',
});

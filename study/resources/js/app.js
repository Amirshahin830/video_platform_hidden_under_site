import './bootstrap';
import 'flowbite';

import Plyr from "plyr";
import "plyr/dist/plyr.css";

const player = new Plyr("#player", {
    iconUrl: "/build/plyr.svg",
});

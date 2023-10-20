import Quill from "quill/quill.js";

var iconsPath = '/quill/assets/icons/';

var icons = Quill.import('ui/icons');
for (var iconName in icons) {
  icons[iconName] = iconName;
}
const quill = new Quill('#adminContentTextarea', {
  theme: 'snow',
  placeholder: 'Compose an epic...',

})
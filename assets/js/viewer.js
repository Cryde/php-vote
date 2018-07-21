import Viewer from 'tui-editor/dist/tui-editor-Viewer';

export default () => {

  const ideaContainer = document.querySelector('#idea-content');

  if (ideaContainer) {
    new Viewer({
      el: ideaContainer,
      height: 'auto',
      initialValue: document.querySelector('.js-idea-content').textContent,
    });
  }
}
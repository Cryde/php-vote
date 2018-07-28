import Viewer from 'tui-editor/dist/tui-editor-Viewer';

export default () => {

  const ideaContainer = document.querySelector('#idea-content');
  const commentContainer = document.querySelector('#comment-container');

  if (ideaContainer) {
    applyView(ideaContainer,
        document.querySelector('.js-idea-content').textContent);
  }

  if (commentContainer) {
    const comments = commentContainer.querySelectorAll('.post-description p');

    [...comments].forEach((item) => {
      const content = JSON.parse(item.getAttribute('data-content'));
      applyView(item, content.text);
    });
  }
}

function applyView(container, text) {
  new Viewer({
    el: container,
    height: 'auto',
    initialValue: text,
  });
}
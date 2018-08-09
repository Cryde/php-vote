import Editor from 'tui-editor';

export default () => {

  const editorElm = document.querySelector('.js-editor');

  if (editorElm) {

    const saveButton = document.querySelector('.js-save-content');
    const textarea = document.querySelector('.js-content-idea');

    const editor = new Editor({
      el: editorElm,
      initialEditType: 'markdown',
      previewStyle: 'tab',
      height: 'auto',
      initialValue: textarea.textContent,
    });

    if (saveButton) {
      saveButton.addEventListener('click', function(e) {
        e.preventDefault();

        textarea.value = editor.getValue();
        this.closest('form').submit();
      });
    }
  }
}
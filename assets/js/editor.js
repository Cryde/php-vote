import Editor from 'tui-editor';

export default () => {

  const editorElm = document.querySelector('.js-editor');

  if (editorElm) {

    const saveButton = document.querySelector('.js-save-content');
    const textarea = document.querySelector('.js-content-idea');

    console.log(textarea.getAttribute('placeholder'));

    const editor = new Editor({
      el: editorElm,
      initialEditType: 'markdown',
      previewStyle: 'tab',
      height: 'auto',
      initialValue: textarea.getAttribute('placeholder'),
    });

    saveButton.addEventListener('click', function(e) {
      e.preventDefault();

      textarea.value = editor.getValue();
      this.closest('form').submit();
    });
  }
}
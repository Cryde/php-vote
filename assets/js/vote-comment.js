import Driver from 'driver.js';
import 'whatwg-fetch';

export default () => {
  const vote = document.querySelector('.js-vote');

  if (vote) {
    handleVoteClick();
  }
}

function handleVoteClick() {
  const voteButtons = document.querySelectorAll('.is_authenticate .js-vote-comment');

  if (voteButtons.length) {
    [...voteButtons].forEach((voteButton) => {
      voteButton.addEventListener('click', onClickEventAuthenticate);
    });
  } else {
    const elements = document.querySelectorAll('.js-vote-comment');
    [...elements].forEach((element) => {
      element.addEventListener('click', onClickEventNotAuthenticate);
    });
  }
}

function onClickEventAuthenticate() {
  const url = this.getAttribute('data-comment-vote-url');

  fetch(url)
  .then((response) => response.json())
  .then(handleResponse.bind(this));
}

function onClickEventNotAuthenticate() {
  const driver = new Driver({opacity: 0, padding: 2});

  driver.highlight({
    element: this,
    popover: {
      title: this.getAttribute('title'),
      description: this.getAttribute('data-content'),
    },
  });
}

function handleResponse(res) {
  const containsClass = this.classList.contains('active');
  removeAllClass(this.parentNode);
  if (!containsClass) {
    this.classList.add('active');
  }
}

function removeAllClass(parent) {
  [...parent.querySelectorAll('.js-vote-comment')].forEach((item) => {
    item.classList.remove('active');
  });
}


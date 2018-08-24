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
  console.log('coucu');
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
  const idea = res.data.idea;
  removeAllClass();
  if (!containsClass) {
    this.classList.add('active');
  }

  document.querySelector('.js-vote[data-vote="1"] span').textContent = idea.total_vote_up;
  document.querySelector('.js-vote[data-vote="-1"] span').textContent = idea.total_vote_down;
}

function removeAllClass() {
  [...document.querySelectorAll('.js-vote')].forEach((item) => {
    item.classList.remove('active');
  });
}


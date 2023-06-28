function setFooterPosition() {
  const body = document.body;
  const html = document.documentElement;
  const footer = document.querySelector('footer');

  const bodyHeight = Math.max(body.scrollHeight, body.offsetHeight);
  const htmlHeight = Math.max(html.scrollHeight, html.offsetHeight);
  const windowHeight = window.innerHeight;

  if (bodyHeight < windowHeight) {
    footer.style.position = 'fixed';
    footer.style.bottom = '0';
    footer.style.left = '0';
    footer.style.width = '100%';
  } else {
    footer.style.position = 'relative';
  }
}

window.addEventListener('load', setFooterPosition);
window.addEventListener('resize', setFooterPosition);
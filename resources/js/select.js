const btn = document.querySelector("#btn");
btn.onclick = unChecked;

function unChecked() {
  let boxes = document.querySelectorAll('input[type="checkbox"]');
  for (let i = 0; i < boxes.length; i++) {
    boxes[i].checked = false;
    this.onclick = checked;
  }
}

function checked() {
  let boxes = document.querySelectorAll('input[type="checkbox"]');

  for (let i = 0; i < boxes.length; i++) {
    boxes[i].checked = true;
    this.onclick = unChecked;
  }
}
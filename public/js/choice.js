
function unChecked() {
  let boxes = document.querySelectorAll('input[type="checkbox"]');
  for (let i = 0; i < boxes.length; i++) {
    boxes[i].checked = false;
  }
 
}

function checked() {
  let boxes = document.querySelectorAll('input[type="checkbox"]');
　for (let i = 0; i < boxes.length; i++) {
    boxes[i].checked = true;
  }
}
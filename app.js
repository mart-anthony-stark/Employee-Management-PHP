const addForm = document.querySelector(".add");
const addOverlay = document.querySelector(".add-overlay");
const addBtn = document.querySelector(".add-emp-btn");
const editForm = document.querySelector(".edit");
const editOverlay = document.querySelector(".edit-overlay");

addBtn.addEventListener("click", () => {
  addForm.classList.remove("hidden");
  addOverlay.classList.remove("hidden");
});

function edit(id) {
  const row = document.querySelector(`#row-${id}`);
  const data = row.querySelectorAll("td");
  const formInputs = editForm.querySelectorAll("input");
  for (let i = 0; i < 4; i++) {
    formInputs[i].value = data[i].innerText;
  }
  formInputs[4].value = new Date(data[4].innerText)
    .toISOString()
    .substring(0, 10);
  editForm.classList.remove("hidden");
  editOverlay.classList.remove("hidden");
}

function hide(form) {
  if (form === "edit") {
    const inputs = editForm.querySelectorAll(".input");
    inputs.forEach((i) => (i.value = ""));
    editForm.classList.add("hidden");
    editOverlay.classList.add("hidden");
  }
}

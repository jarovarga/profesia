/**
 * Form
 */
document
  .querySelectorAll("form input")
  .forEach((e) => {
    inputValidation(e);
  });
document
  .querySelectorAll("form select")
  .forEach((e) => {
    inputValidation(e);
    if (e.options.length > 0 && !e.options[0].value) {
      const attrs = Object.entries({
        disabled: "disabled",
        hidden: "hidden",
      });
      for (const [key, value] of attrs) {
        e.options[0].setAttribute(key, value);
      }
    }
  });

/**
 * Input validation
 */
function inputValidation(e)
{
  e.title = "";
  const error = document.createElement("span");
  const attrs = Object.entries({
    class: "form__error-message",
    // title: e.target.validationMessage,
  });
  for (const [key, value] of attrs) {
    error.setAttribute(key, value);
  }
  e.addEventListener("invalid", (e) => {
    e.target.parentNode.classList.add("--error");
    e.target.parentNode.appendChild(error);
    e.preventDefault();
  }, true);
  e.addEventListener("input", (e) => {
    if (!e.target.validity.valid && e.target.value.length > 0) {
      e.target.parentNode.classList.add("--error");
      e.target.parentNode.appendChild(error);
    } else {
      e.target.parentNode.classList.remove("--error");
      e.target.parentNode
        .querySelectorAll(".form__error-message")
        .forEach(n => n.remove());
    }
  }, true);
}

/**
 * Miscellaneous
 */
document
  .querySelectorAll("a[accesskey]")
  .forEach(function (e) {
    if (e.accessKeyLabel) {
      e.title += " [" + e.accessKeyLabel.toUpperCase() + "]"
    }
  });

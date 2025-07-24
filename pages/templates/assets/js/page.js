var vwu = new Vanilla_website_utils();
var random = Math.floor(Math.random() * 10000000);
window.onload = async function () {
  let input = document.querySelector("#token");
  if (input) {
    let host = await vwu.get_host();
    let url =
      "http://127.0.0.1:8089/token?page={{doc.name}}&client_host=" +
      host +
      "&r=" +
      random;
    const data = JSON.parse(await vwu.aget_api(url));
    const token = data[0]["token"];
    console.log(token);
    input.value = token;
  }

  let random_input = document.querySelector("#random");
  if (random_input) {
    random_input.value = random;
  }

  document
    .querySelector("#btn_submit")
    .addEventListener("click", process_contact_form);
};

function process_contact_form(e) {
  console.log(e.target.closest("form"));
}

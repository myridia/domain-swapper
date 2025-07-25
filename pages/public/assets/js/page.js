var vwu = new Vanilla_website_utils();
var random = Math.floor(Math.random() * 1000);
window.onload = async function () {
  let input = document.querySelector("#token");
  if (input) {
    let host = await vwu.get_host();
    let url =
      "http://127.0.0.1:8089/token?page=domain-swapper&client_host=" +
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

async function process_contact_form(e) {
  const data = await vwu.get_form_data(e.target.closest("form"));
  if (
    data["token"] != "ABCD0123456789" &&
    data["xname"] != "" &&
    data["xmessage"] != ""
  ) {
    //console.log("xxxxx");

    let host = await vwu.get_host();
    let url3 = "http://127.0.0.1:8089/email";
    let ret = await vwu.apost_api(
      url3,
      JSON.stringify(data),
      "application/json",
    );
    console.log(ret);
  } else {
    let contact_msg = document.querySelector("#contact_msg");
    if (contact_msg) {
      contact_msg.innerHTML = "...sending failed. Please review the form fields or send via the email";
    }
  }
}
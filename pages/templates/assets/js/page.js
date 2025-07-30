var vwu = new Vanilla_website_utils();
var random = Math.floor(Math.random() * 1000);
window.onload = async function () {
  const btn_submit = document.querySelector("#btn_submit");
  let input = document.querySelector("#token");
  let random_input = document.querySelector("#random");
  let contact_form = document.querySelector(".contact_form");

  if (input && random_input && btn_submit && contact_form) {
    contact_form.style.visibility = "visible";

    let host = await vwu.get_host();
    let url =
      "{{doc.api}}/token?page={{doc.name}}&client_host=" +
      host +
      "&r=" +
      random;
    const data = JSON.parse(await vwu.aget_api(url));
    const token = data[0]["token"];
    //console.log(data);
    input.value = token;
    random_input.value = random;
    btn_submit.addEventListener("click", process_contact_form);
  }
};

async function refresh_page(e) {
  window.location.reload();
}

async function process_contact_form(e) {
  const data = await vwu.get_form_data(e.target.closest("form"));
  let contact_msg = document.querySelector("#contact_msg");
  contact_msg.addEventListener("click", refresh_page);
  let contact_form = document.querySelector(".contact_form");
  if (contact_msg) {
    contact_msg.innerHTML = "";
  }
  if (
    data["token"] != "ABCD0123456789" &&
    data["xname"] != "" &&
    data["xmessage"] != ""
  ) {
    //console.log("xxxxx");

    let host = await vwu.get_host();
    let url3 = "{{doc.api}}/email";
    const ret = JSON.parse(
      await vwu.apost_api(url3, JSON.stringify(data), "application/json"),
    );
    if (ret["ok"] === true) {
      if (contact_msg) {
        contact_form.style.visibility = "hidden";
        contact_msg.innerHTML = "{{page.contact_msg_success}}";
      }
    } else {
      if (contact_msg) {
        contact_form.style.visibility = "hidden";
        contact_msg.innerHTML = "{{page.contact_msg_failed}}";
      }
    }
  } else {
    if (contact_msg) {
      if (contact_msg) {
        contact_form.style.visibility = "hidden";
        contact_msg.innerHTML = "{{page.contact_msg_failed}}</a>";
      }
    }
  }
}

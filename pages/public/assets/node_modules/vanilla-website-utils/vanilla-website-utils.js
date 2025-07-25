/**
 * GPL licenses
 * A module for Vanilla-website-utils
 * @module Vanilla-website-utils
 */
"use strict";

module.exports = class Vanilla_website_utils {
  constructor() {}

  /**
@alias module:Vanilla-website-utils
@param {int} -  number of years back in time - default is 0, what brings only the actual year
@returns {array} - file object with month back in time with the starting and end date of a 112 date format
@example
* var vwu = new Vanilla_website_utils();
* months = vwu.get_month_back(5)
*/

  async get_month_back(yrs = 0) {
    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    let obj = {};

    const today = new Date();
    let today_year = today.getFullYear();
    let today_month = today.getMonth();
    let today_day = today.getDate().toString().padStart(2, "0");
    let today_year_month =
      today_year + (today_month + 1).toString().padStart(2, "0");

    for (let y = 0; y < yrs + 1; y++) {
      let year = today_year - y;

      for (let m = 0; m < months.length; m++) {
        let ms = year + "" + (m + 1).toString().padStart(2, "0");
        if (ms <= today_year_month) {
          const start = ms + "" + "01";
          let end = ms + "" + new Date(year, m + 1, 0).getDate();
          if (ms === today_year_month) {
            end = today_year_month + "" + today_day;
          }
          const name = months[m] + " " + year;
          obj[start] = { start: start, end: end, name: name };
        }
      }
    }
    let r = [];
    let keys = Object.keys(obj).sort().reverse();
    for (let i in keys) {
      r.push(obj[keys[i]]);
    }

    return r;
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - file object from a HTML website
@returns {array} - the collected data from the csv file into an array
@example
* var vwu = new Vanilla_website_utils();
* document.querySelector("#input").addEventListener("change", function(){
* let arr = vwu.file_to_array(this.files[0]);
},false)

*/
  async csv_file_to_array(file) {
    let rows = [];
    const str = await file.text();
    const lines = str.split(/[\r\n]+/);
    for (let i in lines) {
      let row = lines[i]
        .split(/\s*,\s*/)
        .map((x) => (x === "" ? "" : isNaN(Number(x)) ? x : Number(x)));
      rows.push(row);
    }
    return rows;
  }

  /**
@alias module:Vanilla-website-utils
@example
* var vwu = new Vanilla_website_utils();
* vwu.clear_textarea()
*/
  clear_textarea() {
    let t = document.getElementsByTagName("textarea");

    for (let i in t) {
      if (t[i].type === "textarea") {
        t[i].value = "";
      }
    }
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - javascript object
@param {string} - desc or asc  (default desc)
@returns {array}
@example
* var vwu = new Vanilla_website_utils();
* let obj = {a:100,b:50,c:75,d:1};
* let a = vwu.sort_object('desc'); 
*/
  sort_object(obj, sort_order = "desc") {
    let sortable = [];
    for (let i in obj) {
      sortable.push([i, obj[i]]);
    }
    sortable.sort(function (a, b) {
      if (sort_order === "asc") {
        return a[1] - b[1];
      } else {
        return b[1] - a[1];
      }
    });
    return sortable;
  }

  /**
@alias module:Vanilla-website-utils
@param {str} - a 112 string type date
@param {int} - add days or remove by adding -1 or 1
@returns {object} - date object  
@example
* var vwu = new Vanilla_website_utils();
* let date = vwu.112_to_date('20240601'); 
*/

  from_112_to_date(str, add_days = 0) {
    const _year = str.substring(0, 4);
    const _month = str.substring(4, 6);
    const _day = str.substring(6, 8);
    const year = parseInt(_year);
    const month = parseInt(_month);
    const day = parseInt(_day);
    let d = new Date(year, month - 1, day);
    d.setDate(d.getDate() + add_days);
    return d;
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - dateobject
@returns {string} - in 112 format like 20230515 
@example
* var vwu = new Vanilla_website_utils();
* let date = new Date();
* let iso_112 = vwu.date_to_112(date); 
*/

  date_to_112(_date) {
    let self = this;
    let d112 =
      _date.getUTCFullYear() +
      "" +
      self.pad(_date.getMonth() + 1) +
      "" +
      self.pad(_date.getDate()) +
      "";
    return d112;
  }

  /**
@alias module:Vanilla-website-utils
@param {int} - number of month back 
@param {bolean} - revert order - Default is false 
@param {string} - return format of the month year pair - Default {j}.{i} like 09.2022 | j = month | i =year | 
@returns {arry} - list of month in format like 10.2022
@example
* var vwu = new Vanilla_website_utils();
* let data = await vwu.month_list(60,true,"`${j}.${i}`");
*/

  async month_list(month_back = 12, revert = false, format = "`${j}.${i}`") {
    let date = new Date();
    date.setMonth(date.getMonth() - month_back);
    let startDate =
      String(date.getMonth() + 1) + "." + String(date.getFullYear());
    let data = [];
    let d = new Date();
    let m = d.getMonth() + 1;
    let y = d.getFullYear().toString();
    d = startDate.split(".");
    let counter = parseInt(d[0]);
    for (var i = parseInt(d[1]); i <= parseInt(y); i++) {
      for (var j = counter; j <= 12; j++) {
        if (j > m && i == y) {
          continue;
        }
        if (j < 10) {
          j = "0" + j;
        }
        let f = eval(format);
        data.push(f);
      }
      counter = 1;
    }
    if (revert === true) {
      data = data.reduce((acc, item) => [item].concat(acc), []);
    }
    return data;
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - extentison
@returns {string} - the hostname
@example
* var vwu = new Vanilla_website_utils();
* let host = await vwu.get_host();
*/
  async get_host(ext = "html") {
    let u = String(location).split("/");
    for (let i = 1; i < u.length; i++) {
      if (u[i].indexOf(".") > 0 && u[i].indexOf(ext) < 0) {
        return u[i];
      }
    }
    return false;
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - url 
@returns {object} json pair key/value
@example
* var vwu = new Vanilla_website_utils();
* let v = await vwu.get_parameters();
*/
  async get_parameters(url) {
    if (!url) url = window.location.href;
    let question = url.indexOf("?");
    let hash = url.indexOf("#");
    if (hash == -1 && question == -1) return {};
    if (hash == -1) hash = url.length;
    let query =
      question == -1 || hash == question + 1
        ? url.substring(hash)
        : url.substring(question + 1, hash);
    var result = {};
    query.split("&").forEach(function (part) {
      if (!part) {
        return;
      }
      part = part.split("+").join(" "); // replace every + with space, regexp-free version
      let eq = part.indexOf("=");
      let key = eq > -1 ? part.substr(0, eq) : part;
      let val = eq > -1 ? decodeURIComponent(part.substr(eq + 1)) : "";
      let from = key.indexOf("[");

      if (from == -1) {
        let _key = decodeURIComponent(key);
        if (!result[_key]) {
          result[_key] = val;
        } else {
          //console.log(val);
          if (!Array.isArray(result[_key])) {
            result[_key] = [result[_key]];
            result[_key].push(val);
          } else {
            result[_key].push(val);
          }
        }
      } else {
        let to = key.indexOf("]", from);
        var index = decodeURIComponent(key.substring(from + 1, to));
        key = decodeURIComponent(key.substring(0, from));

        if (!result[key]) {
          result[key] = [];
        }
        if (!index) {
          result[key].push(val);
        } else {
          result[key][index] = val;
        }
      }
    });

    return result;
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - the DOM select object
@param {string} - value
@returns {string} text 
@example
* var vwu = new Vanilla_website_utils();
* let mytext = await vwu.get_select_text_by_value(document.querySelector("#resource"), v['resource'],v['resource']);
*/
  async get_select_text_by_value(select, value, _default = "All") {
    for (var i = 0; i < select.length; i++) {
      const option = select.options[i];
      if (option.value == value) {
        return option.text;
      }
    }
    return _default;
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - original url
@param {string} - json like {'foo':'bar'}
@returns {string} url plus the new parameters
@example
* var vwu = new Vanilla_website_utils();
* filter = {"foo":"bar"};
* url = await vwu.add_parameters(url, filter);
*/
  async add_parameters(url, parameters) {
    let sep = "?";
    if (url.indexOf("?") > -1) {
      sep = "&";
    }
    for (let i in parameters) {
      url += sep + i + "=" + parameters[i];
      sep = "&";
    }
    return url;
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - api url
@param {string} - user - for Basic Authorization
@param {string} - password - for Basic Authorization
@param {string} - token - for Bearer Authorization
@returns {object} json 
@example
* var vwu = new Vanilla_website_utils();
* let res = await vwu.aget_api(url);
*/
  async aget_api(url, user = "", password = "", token = "") {
    return new Promise((resolve, reject) => {
      let xhr = new XMLHttpRequest();
      xhr.open("GET", url, true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      if (user != "" && password != "") {
        const base64 = btoa(user + ":" + password);
        xhr.setRequestHeader("Authorization", "Basic " + base64);
      } else if (token != "") {
        xhr.setRequestHeader("Authorization", "Bearer " + token);
      } else {
      }
      xhr.onload = function () {
        return resolve(xhr.responseText);
      };
      xhr.onerror = function () {
        return reject(xhr.statusText);
      };
      xhr.send(null);
    });
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - api url
@param {object} - data
@param {string} - content type of the sending data optional - default is "application/json"
@returns {object} json 
@example
* let data = {"foo":"bar"}
* var vwu = new Vanilla_website_utils();
* let res = await vwu.apost_api(url, data, "application/json");
*/
  async aput_api(url, data, content_type = "application/json") {
    if (typeof data == "object") {
      data = JSON.stringify(filter);
    }

    return new Promise((resolve, reject) => {
      let xhr = new XMLHttpRequest();
      xhr.open("PUT", url);
      xhr.setRequestHeader("Content-type", "application/json");
      xhr.onload = () => resolve(xhr.responseText);
      xhr.onerror = () => reject(xhr.statusText);
      xhr.send(data);
    });
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - api url
@param {object} - data
@param {string} - content type of the sending data optional - default is "application/json"
@returns {object} json 
@example
* var vwu = new Vanilla_website_utils();
* let res = await vwu.apost_api(url, data, "application/json");
*/
  async apost_api(url, data, content_type = "application/json") {
    return new Promise((resolve, reject) => {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", url);
      xhr.setRequestHeader("Content-type", content_type);
      xhr.onload = () => resolve(xhr.responseText);
      xhr.onerror = () => reject(xhr.statusText);
      xhr.send(data);
    });
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - api url
@param {object} - data
@param {string} - name of the callback function
@param {string} - content type of the sending data optional - default is "application/json"
@returns {object} json 
@example
* var vwu = new Vanilla_website_utils();
* let data = {"foo":"bar"}
* let ret = vwu.post_api('http://foo.bar/api','myfuncion','application/json') 
*/
  post_api(
    url,
    {},
    my_callback,
    _data = {},
    content_type = "application/json",
  ) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url);
    xhr.setRequestHeader("Content-type", content_type);
    xhr.onload = function () {
      if (xhr.status === 200) {
        let r = JSON.parse(xhr.responseText);
        my_callback(r, true, _data);
      } else {
        my_callback(xhr.responseText, false, _data);
      }
    };

    xhr.onerror = function () {
      my_callback(xhr, false, _data);
    };
    xhr.send(_data);
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - email
@returns {bolan} true if ok and false if bad email
@example
* var vwu = new Vanilla_website_utils();
* const ok = vwu._email_validator(foo@bar.com)
*/

  _email_validator(email) {
    let tester =
      /^[-!#$%&'*+\/0-9=?A-Z^_a-z{|}~](\.?[-!#$%&'*+\/0-9=?A-Z^_a-z`{|}~])*@[a-zA-Z0-9](-?\.?[a-zA-Z0-9])*\.[a-zA-Z](-?[a-zA-Z0-9])+$/;
    if (!email) {
      return false;
    }

    if (email.length > 254) {
      return false;
    }

    let valid = tester.test(email);
    if (!valid) {
      return false;
    }

    let parts = email.split("@");
    if (parts[0].length > 64) {
      return false;
    }

    let domainParts = parts[1].split(".");
    if (
      domainParts.some(function (part) {
        return part.length > 63;
      })
    )
      return false;

    return true;
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - email
@returns {bolan} true if ok and false if bad email
@example
* var vwu = new Vanilla_website_utils();
* const ok = await vwu._email_validator(foo@bar.com)
*/
  async email_validator(email) {
    let tester =
      /^[-!#$%&'*+\/0-9=?A-Z^_a-z{|}~](\.?[-!#$%&'*+\/0-9=?A-Z^_a-z`{|}~])*@[a-zA-Z0-9](-?\.?[a-zA-Z0-9])*\.[a-zA-Z](-?[a-zA-Z0-9])+$/;
    if (!email) {
      return false;
    }

    if (email.length > 254) {
      return false;
    }

    let valid = tester.test(email);
    if (!valid) {
      return false;
    }

    let parts = email.split("@");
    if (parts[0].length > 64) {
      return false;
    }

    let domainParts = parts[1].split(".");
    if (
      domainParts.some(function (part) {
        return part.length > 63;
      })
    )
      return false;

    return true;
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - key of the url parameter
@returns {string} url parameter
@example
* var vwu = new Vanilla_website_utils();
* const from = await vwu.get_url_parameter('from')
*/
  async get_url_parameter(name) {
    return (
      decodeURIComponent(
        (new RegExp("[?|&]" + name + "=" + "([^&;]+?)(&|#|;|$)").exec(
          location.search,
        ) || [null, ""])[1].replace(/\+/g, "%20"),
      ) || null
    );
  }

  /**
@alias module:Vanilla-website-utils
@returns {string} sitename
@example
* var vwu = new Vanilla_website_utils();
* let site = vwu.get_site
*/
  async get_site() {
    let u = String(location).split("/");
    return u[u.length - 1].replace(".html", "");
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - see example
@param search in object can be begining(default) or inline
@example 
*  var vwu = new Vanilla_website_utils();
*  await vwu.autocomplete_textfield({
*      url: api + '/code/name',
*        onetimeload: true,
*        dom_id: 'search',
*        name: 'search',
*        append_to: '#nav-search',
*        min_key_length: 2
*        search: inline
*      });
*      url: api + '/code/name',
*        onetimeload: true,
*        dom_id: 'search',
*        name: 'search',
*        append_to: '#nav-search',
*        min_key_length: 2
*        search: beginning
*      });

*/
  async autocomplete_textfield(setting) {
    let data = setting["data"] ? setting["data"] : false;
    let url = setting["url"] ? setting["url"] : false;
    let dom_id = setting["dom_id"] ? setting["dom_id"] : false;
    let name = setting["name"] ? setting["name"] : false;
    let type_delay = setting["type_delay"] ? setting["type_delay"] : 500;
    let search_indicator = setting["search_indicator"]
      ? setting["search_indicator"]
      : false;
    let min_key_length = setting["min_key_length"]
      ? setting["min_key_length"]
      : 3;
    let onetimeload =
      setting["onetimeload"] == true ? setting["onetimeload"] : false;
    let min_dropdown = setting["min_dropdown"] ? setting["min_dropdown"] : 20;
    let append_to = setting["append_to"] ? setting["append_to"] : false;
    const search = setting["search"] ? setting["search"] : "beginning";
    if (url) {
      if (onetimeload === true && url && dom_id && name) {
        this.autocomplete_onetime(
          url,
          dom_id,
          name,
          min_key_length,
          min_dropdown,
          append_to,
          search,
        );
      } else {
        this._set_textfield(
          url,
          dom_id,
          name,
          min_key_length,
          search_indicator,
          type_delay,
          min_dropdown,
          append_to,
          search,
        );
      }
    }
    if (data) {
      //      console.log(data);
    }
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - see example 
@example 
*  var vwu = new Vanilla_website_utils();
*  await vwu.autocomplete_select({
*      url: api + '/code/name',
*        onetimeload: true,
*        dom_id: 'search',
*        name: 'search',
*      });

*/
  async autocomplete_select(setting) {
    let url = setting["url"] ? setting["url"] : false;
    let dom_id = setting["dom_id"] ? setting["dom_id"] : false;
    let selected = setting["selected"] ? setting["selected"] : "";
    let name = setting["name"] ? setting["name"] : false;
    if (url) {
      let selector = document.querySelector("#" + dom_id);
      let data = JSON.parse(await this.aget_api(url));
      this.fill_select(selector, data, selected);
    }
  }

  async autocomplete_onetime(
    url,
    dom_id,
    name,
    min_key_length,
    min_dropdown,
    append_to,
    search,
  ) {
    let self = this;
    let textfield = document.querySelector("#" + dom_id);
    if (textfield) {
      textfield.setAttribute("placeholder", "Loading " + name + "...");
      textfield.setAttribute("autocomplete", "off");
      let _class = textfield.getAttribute("class");
      textfield.setAttribute("class", _class + " autocomplete");
      let _data = await this.aget_api(url);
      if (_data.length) {
        let data = JSON.parse(_data);
        // if input is just array convert to object - later catch dynamci input
        if (data instanceof Array) {
          let obj = {};
          for (let x = 0; x < data.length; x++) {
            obj[data[x]] = data[x];
          }
          data = obj;
        }

        textfield.placeholder = "Enter " + name + "...";
        textfield.addEventListener("keyup", async function (e) {
          if (e.target.value.length >= min_key_length) {
            await self.autocomplete(
              e.target.value,
              textfield,
              data,
              min_dropdown,
              append_to,
              search,
            );
          }
        });
      }
    }
  }

  /**
@alias module:Vanilla-website-utils
*/
  async _set_textfield(
    url = "html",
    dom_id = "domid",
    name = "",
    min_key_length = 3,
    search_indicator,
    type_delay,
    min_dropdown,
    append_to,
    search,
  ) {
    let delay = (function () {
      let timer = 0;
      return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
      };
    })();

    let self = this;
    let textfield = document.querySelector("#" + dom_id);
    if (textfield) {
      textfield.setAttribute("placeholder", "Enter " + name + "...");
      textfield.setAttribute("autocomplete", "off");
      let _class = textfield.getAttribute("class");
      textfield.setAttribute("class", _class + " autocomplete");
      textfield.addEventListener("keyup", async function (e) {
        delay(async function () {
          await self.autocomplete_keylog(
            e,
            textfield,
            url,
            dom_id,
            name,
            min_key_length,
            min_dropdown,
            ppend_to,
            search,
          );
        }, type_delay);
      });
    }
    return false;
  }

  /**
@alias module:Vanilla-website-utils
*/
  async autoload_textfield(
    url = "html",
    dom_id = "domid",
    name = "",
    min_key_length,
    search,
  ) {
    this._set_textfield(url, dom_id, name);
  }

  async autocomplete_keylog(
    e,
    textfield,
    url,
    dom_id,
    name,
    min_key_length = 3,
    min_dropdown = 20,
    append_to = false,
    search,
  ) {
    let parameters = { k: e.target.value };
    url = await this.add_parameters(url, parameters);
    if (parameters.k.length >= min_key_length) {
      //console.log(parameters.k);
      //console.log(url);
      let _data = await this.aget_api(url);
      //console.log(_data);
      if (_data.length) {
        let data = JSON.parse(_data);
        await this.autocomplete(
          e.target.value,
          textfield,
          data,
          min_dropdown,
          append_to,
          search,
        );
      }
    }
  }

  /**
@alias module:Vanilla-website-utils
*/
  async autocomplete(
    val,
    inp,
    data,
    min_dropdown = 20,
    append_to = false,
    search,
  ) {
    //console.log("..." + search);

    let append = inp;
    if (append_to) {
      append = document.querySelector(append_to);
    }
    if (Array.isArray(data) === false) {
      data = [data];
    }

    var o = this;
    var currentFocus;
    let _arr = [];
    let arr = [];
    for (let i in data) {
      let k = Object.values(data[i]);
      _arr = _arr.concat(k);
    }

    // check if the data is a nested array/object, so take the key in case
    for (let i in _arr) {
      if (typeof _arr[i] == "object") {
        arr.push(_arr[i][0]);
      } else {
        arr = _arr;
        break;
      }
    }

    document.addEventListener("click", function (e) {
      //console.log("...close");
      o.close_all_lists(e.target);
    });

    o.close_all_lists();
    const _id = append.id ? append.id : append.name;
    const otop = append.offsetTop + append.offsetHeight + 1;
    const oleft = append.offsetLeft;
    let a = document.createElement("DIV");
    a.setAttribute("id", _id + "_autocomplete-list");
    a.setAttribute("class", "autocomplete-items");
    a.style.top = otop + "px";
    a.style.left = oleft + "px";
    append.parentNode.appendChild(a);

    let count = 0;
    for (let i = 0; i < arr.length; i++) {
      if (count > min_dropdown) {
        break;
      }

      if (search === "inline") {
        let index = arr[i].toUpperCase().indexOf(val.toUpperCase());
        if (index > -1) {
          let b = document.createElement("DIV");
          let sub = arr[i].substr(index, val.length);
          b.innerHTML = arr[i].replace(sub, "<strong>" + sub + "</strong>");
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          b.addEventListener("click", function (e) {
            inp.value = this.getElementsByTagName("input")[0].value;
            o.close_all_lists(this);
          });
          a.appendChild(b);
          count++;
        }
      } else {
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          let b = document.createElement("DIV");
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          b.addEventListener("click", function (e) {
            inp.value = this.getElementsByTagName("input")[0].value;
            o.close_all_lists(this);
          });
          a.appendChild(b);
          count++;
        }
      }
    }
  }

  add_active(x) {
    /*a function to classify an item as "active":*/
    if (!x) {
      return false;
    }

    this.remove_active(x);

    if (currentFocus >= x.length) {
      currentFocus = 0;
    }
    if (currentFocus < 0) {
      currentFocus = x.length - 1;
    }
    x[currentFocus].classList.add("autocomplete-active");
  }

  remove_active(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }

  close_all_lists(e) {
    let x = document.getElementsByClassName("autocomplete-items");
    for (let i = 0; i < x.length; i++) {
      x[i].parentNode.removeChild(x[i]);
    }
  }

  /**
@alias module:Vanilla-website-utils
@param {string} - id from a enbedded Textfield into a form tag
@param {string} - url string where to post the data rows
@param {string} - callback function, you need to declare a callbackup what will be called after the post
@returns {callback} - callback call
@example
* it will disable the form submit 
* var vwu = new Vanilla_website_utils();
* let array= vwu.get_text_rows);
*/
  post_textfield_rows(id, url, callback) {
    let self = this;
    const form = document.querySelector("#" + id).closest("form");
    form.onsubmit = function () {
      self._post_textfield_rows(this, id, url, callback);
      return false;
    };
  }

  async _post_textfield_rows(o, id, url, callback) {
    let x = await vwu.get_form_data(o);
    let a = JSON.parse(decodeURIComponent(x[id]));
    data = await vwu.apost_api(url, JSON.stringify(a));
    window[callback](data);
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - form object 
@returns {array} in key/value as JSON   
@example
* var vwu = new Vanilla_website_utils();
* let data = JSON.stringify(await vwu.get_form_data(form));
*/
  async get_form_data(form) {
    let e = form.getElementsByTagName("input");
    let pairs = [];
    for (let i = 0; i < e.length; i++) {
      if (
        [
          "text",
          "email",
          "tel",
          "time",
          "url",
          "week",
          "password",
          "number",
          "month",
          "hidden",
          "datetime-local",
          "date",
          "color",
        ].includes(e[i].type)
      ) {
        pairs.push(
          encodeURIComponent(e[i].name) +
            "=" +
            encodeURIComponent(e[i].value.trim()),
        );
      }

      if (e[i].type == "radio") {
        if (e[i].checked) {
          pairs.push(
            encodeURIComponent(e[i].name) +
              "=" +
              encodeURIComponent(e[i].value.trim()),
          );
        }
      }

      if (e[i].type == "checkbox") {
        if (e[i].checked) {
          pairs.push(
            encodeURIComponent(e[i].name) +
              "=" +
              encodeURIComponent(e[i].value.trim()),
          );
        }
      }
    }

    let t = form.getElementsByTagName("textarea");
    for (let i = 0; i < t.length; i++) {
      let _a = t[i].value.split("\n");
      let a = [];
      for (let x = 0; x < _a.length; x++) {
        let v = _a[x].trim();
        if (v) {
          a.push(v);
        } else {
          a.push("");
        }
      }
      //a = a.filter(function (el) {return el != '';});
      if (a.length) {
        if (a[a.length - 1].trim() === "") {
          a.pop();
        }
        let j = JSON.stringify(a);
        pairs.push(encodeURIComponent(t[i].name) + "=" + encodeURIComponent(j));
      }
    }

    // check for select
    const s = form.getElementsByTagName("select");
    if (s.length > 0) {
      for (let i = 0; i < s.length; i++) {
        let j = s[i].value.trim();
        if (s[i].type == "select-multiple") {
          const m = get_select_values(s[i]);
          pairs.push(
            encodeURIComponent(s[i].name) + "=" + encodeURIComponent(m),
          );
        } else {
          pairs.push(
            encodeURIComponent(s[i].name) + "=" + encodeURIComponent(j),
          );
        }
      }
    }

    let data = {};
    for (let x = 0; x < pairs.length; x++) {
      let a = pairs[x].split("=");
      if (a.length === 2) {
        data[a[0]] = a[1];
      }
    }
    //let data = pairs.join("&");
    return data;
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - DOM object
@param {object} - data array
 
@example
*  var vwu = new Vanilla_website_utils();
*  let extra_sel = document.querySelector("#extra");
*  await vwu.fill_select(extra_sel, data);
*/
  s_fill_select(select_obj, data) {
    this.fill_select(select_obj, data);
  }
  /**
@alias module:Vanilla-website-utils
@param {object}  - DOM object
@param {object}  - data array
@param {string}  - select element
@param {boolean} - copy2clipboard true or false
@param {object}  - log object - experimental
@example
* var vwu = new Vanilla_website_utils();
* const url = api + '/fields?table=av0_style&db=sl&server=232&f=list';
* const data = JSON.parse(await aget_api(url));
* let extra_sel = document.querySelector("#extra");
* await vwu.fill_select(extra_sel, data);
* await vwu.fill_select(sel,all_tags,'height: 500px; width: 230px;font-size: 9px',true, log);
*/
  async fill_select(
    select_obj,
    data,
    selected = "",
    copy2clipboard = false,
    log = false,
  ) {
    //select_obj.style = selected;
    for (const i in data) {
      let val = data[i];
      let text = data[i];

      if (typeof data[i] === "object") {
        if (data[i].length === 2) {
          val = data[i][0];
          text = data[i][1];
        }
      }
      let opt = document.createElement("option");
      if (val == selected) {
        opt.setAttribute("selected", "selected");
      }
      opt.value = val;
      opt.innerHTML = text;
      select_obj.appendChild(opt);
    }
    if (copy2clipboard) {
      select_obj.addEventListener("change", function () {
        let f = select_obj.options[select_obj.selectedIndex].value;
        navigator.clipboard.writeText(f);
        if (log) {
          log.info("copy to clipboard");
        }
      });
    }
  }

  /**
@alias module:Vanilla-website-utils
@param {int} - number 
@return {string} - data array
@example
*  var vwu = new Vanilla_website_utils();
*  let x = vwu.pad(5);
*/
  pad(number) {
    if (number < 10) {
      return "0" + number;
    }
    return number;
  }

  /**
@alias module:Vanilla-website-utils
@param {object} - DOM object
@param {object} - data array
@example
*  var vwu = new Vanilla_website_utils();
*  let extra_sel = document.querySelector("#extra");
*  await vwu.fill_select(extra_sel, data);
*/
  s_set_selected(select_obj, data) {
    this.set_selected(select_obj, data);
  }

  /**
@alias module:Vanilla-website-utils
@example
*  var vwu = new Vanilla_website_utils(); 
* let select = document.querySelector("#bom");
* await vwu.set_selected(select,v['bom']);
*/
  async set_selected(select_obj, data) {
    //console.log(data);

    for (const option of select_obj.querySelectorAll("option")) {
      const value = option.value;
      if (data.indexOf(value) !== -1) {
        option.setAttribute("selected", "selected");
      } else {
        option.removeAttribute("selected");
      }
    }
  }

  /**
 
* Async Delete request used by function delete_row
@alias module:Jqgrid_utils
@param {string} - url of the API
@param {object} - json databoy or not (default is false) - optional
@returns {object} Object from the the API like {msg: 'ok'} or {delete: 'failed'} - optional 
@example
var jqu = new Jqgrid_utils(); 
afterDelRow: async function(row)
{ 
ret = JSON.parse(await vwu.adelete_api(url)); 
},
*/

  async adelete_api(url, json = false) {
    let ctype = "application/x-www-form-urlencoded";
    let body = null;
    if (json) {
      ctype = "application/json;charset=UTF-8";
      body = json;
    }
    return new Promise((resolve, reject) => {
      let xhr = new XMLHttpRequest();
      xhr.open("DELETE", url);
      xhr.setRequestHeader("Content-type", ctype);
      xhr.onload = () => resolve(xhr.responseText);
      xhr.onerror = () => reject(xhr.statusText);
      xhr.send(body);
    });
  }

  /**
* Count the lines of Textarea and fill it to a target 
@alias module:Jqgrid_utils
@param {string} - source textarea id 
@param {string} - target textarea id 

@example
vwu.textarea_line_counter("foo_id","foo_id_c");
vwu.textarea_line_counter("bar_id","bar_id_c")
*/

  textarea_line_counter(sid = false, tid = false) {
    let self = this;
    let source = document.querySelector("#" + sid);
    let target = document.querySelector("#" + tid);

    if (source && target) {
      let lines = source.value.split("\n");
      let count = lines.length;
      target.innerHTML = "" + count + "";

      source.addEventListener("change", function () {
        self._textarea_line_counter(source, target);
      });
      source.addEventListener("keyup", function () {
        self._textarea_line_counter(source, target);
      });
      source.addEventListener("keydown", function () {
        self._textarea_line_counter(source, target);
      });
    }
  }

  _textarea_line_counter(source = false, target = false) {
    if (source && target) {
      let lines = source.value.split("\n");
      let count = lines.length;
      target.innerHTML = "" + count + "";
    }
  }
};

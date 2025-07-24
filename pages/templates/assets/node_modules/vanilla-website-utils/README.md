# Vanilla-website-utils
Vanilla JS utility functions
for daily website usage

# Feeback
If you are using or are interested in this module, please send me some Feedback.
Any comment, request or critic is welcome!
veto@myridia.com

# Install 
```bash
  npm install vanilla-website-utils
```

# Usage:
```html
  <script src="../node_modules/vanilla-website-utils/dist/vanilla-website-utils.js"></script>
```


## Example Usage:
```javascript
  var vu = new Vanilla_website_utils();
  window.onload = async function()
  {
	const host = await vu.get_host();
	const v = await vu.get_parameters();
	console.log(host);
	console.log(v);
  };
   	
```

## Functions:

```html
    <form>
      <input  id="test" class="test" />
    </form>
```

```javascript
   await vwu.autoload_textfield("http://127.0.0.1:8051/book_authors_name?f=data&_max=100",'test','test')
```

## Repro:
  https://calantas.org/vanilla-website-utils
<a name="module_Vanilla-website-utils"></a>

## Vanilla-website-utils
GPL licenses
A module for Vanilla-website-utils


* [Vanilla-website-utils](#module_Vanilla-website-utils)
    * [module.exports#get_month_back(yrs)](#exp_module_Vanilla-website-utils--module.exports+get_month_back) ⇒ <code>array</code> ⏏
    * [module.exports#csv_file_to_array(file)](#exp_module_Vanilla-website-utils--module.exports+csv_file_to_array) ⇒ <code>array</code> ⏏
    * [module.exports#clear_textarea()](#exp_module_Vanilla-website-utils--module.exports+clear_textarea) ⏏
    * [module.exports#sort_object(obj, sort_order)](#exp_module_Vanilla-website-utils--module.exports+sort_object) ⇒ <code>array</code> ⏏
    * [module.exports#from_112_to_date(str, add_days)](#exp_module_Vanilla-website-utils--module.exports+from_112_to_date) ⇒ <code>object</code> ⏏
    * [module.exports#date_to_112(_date)](#exp_module_Vanilla-website-utils--module.exports+date_to_112) ⇒ <code>string</code> ⏏
    * [module.exports#month_list(month_back, revert, format)](#exp_module_Vanilla-website-utils--module.exports+month_list) ⇒ <code>arry</code> ⏏
    * [module.exports#get_host(ext)](#exp_module_Vanilla-website-utils--module.exports+get_host) ⇒ <code>string</code> ⏏
    * [module.exports#get_parameters(url)](#exp_module_Vanilla-website-utils--module.exports+get_parameters) ⇒ <code>object</code> ⏏
    * [module.exports#get_select_text_by_value(select, value)](#exp_module_Vanilla-website-utils--module.exports+get_select_text_by_value) ⇒ <code>string</code> ⏏
    * [module.exports#add_parameters(url, parameters)](#exp_module_Vanilla-website-utils--module.exports+add_parameters) ⇒ <code>string</code> ⏏
    * [module.exports#aget_api(url, user, password, token)](#exp_module_Vanilla-website-utils--module.exports+aget_api) ⇒ <code>object</code> ⏏
    * [module.exports#aput_api(url, data, content_type)](#exp_module_Vanilla-website-utils--module.exports+aput_api) ⇒ <code>object</code> ⏏
    * [module.exports#apost_api(url, data, content_type)](#exp_module_Vanilla-website-utils--module.exports+apost_api) ⇒ <code>object</code> ⏏
    * [module.exports#post_api(url, my_callback, _data)](#exp_module_Vanilla-website-utils--module.exports+post_api) ⇒ <code>object</code> ⏏
    * [module.exports#_email_validator(email)](#exp_module_Vanilla-website-utils--module.exports+_email_validator) ⇒ <code>bolan</code> ⏏
    * [module.exports#email_validator(email)](#exp_module_Vanilla-website-utils--module.exports+email_validator) ⇒ <code>bolan</code> ⏏
    * [module.exports#get_url_parameter(name)](#exp_module_Vanilla-website-utils--module.exports+get_url_parameter) ⇒ <code>string</code> ⏏
    * [module.exports#get_site()](#exp_module_Vanilla-website-utils--module.exports+get_site) ⇒ <code>string</code> ⏏
    * [module.exports#autocomplete_textfield(setting, search)](#exp_module_Vanilla-website-utils--module.exports+autocomplete_textfield) ⏏
    * [module.exports#autocomplete_select(setting)](#exp_module_Vanilla-website-utils--module.exports+autocomplete_select) ⏏
    * [module.exports#_set_textfield()](#exp_module_Vanilla-website-utils--module.exports+_set_textfield) ⏏
    * [module.exports#autoload_textfield()](#exp_module_Vanilla-website-utils--module.exports+autoload_textfield) ⏏
    * [module.exports#autocomplete()](#exp_module_Vanilla-website-utils--module.exports+autocomplete) ⏏
    * [module.exports#post_textfield_rows(id, url, callback)](#exp_module_Vanilla-website-utils--module.exports+post_textfield_rows) ⇒ <code>callback</code> ⏏
    * [module.exports#get_form_data(form)](#exp_module_Vanilla-website-utils--module.exports+get_form_data) ⇒ <code>array</code> ⏏
    * [module.exports#s_fill_select(select_obj, data)](#exp_module_Vanilla-website-utils--module.exports+s_fill_select) ⏏
    * [module.exports#fill_select(select_obj, data, selected, copy2clipboard, log)](#exp_module_Vanilla-website-utils--module.exports+fill_select) ⏏
    * [module.exports#pad(number)](#exp_module_Vanilla-website-utils--module.exports+pad) ⇒ <code>string</code> ⏏
    * [module.exports#s_set_selected(select_obj, data)](#exp_module_Vanilla-website-utils--module.exports+s_set_selected) ⏏
    * [module.exports#set_selected()](#exp_module_Vanilla-website-utils--module.exports+set_selected) ⏏

<a name="exp_module_Vanilla-website-utils--module.exports+get_month_back"></a>

### module.exports#get\_month\_back(yrs) ⇒ <code>array</code> ⏏
**Kind**: Exported function  
**Returns**: <code>array</code> - - file object with month back in time with the starting and end date of a 112 date format  

| Param | Type | Default | Description |
| --- | --- | --- | --- |
| yrs | <code>int</code> | <code>0</code> | number of years back in time - default is 0, what brings only the actual year |

**Example**  
```js
var vwu = new Vanilla_website_utils();
months = vwu.get_month_back(5)
```
<a name="exp_module_Vanilla-website-utils--module.exports+csv_file_to_array"></a>

### module.exports#csv\_file\_to\_array(file) ⇒ <code>array</code> ⏏
**Kind**: Exported function  
**Returns**: <code>array</code> - - the collected data from the csv file into an array  

| Param | Type | Description |
| --- | --- | --- |
| file | <code>object</code> | file object from a HTML website |

**Example**  
```js
var vwu = new Vanilla_website_utils();
document.querySelector("#input").addEventListener("change", function(){
let arr = vwu.file_to_array(this.files[0]);
},false)
```
<a name="exp_module_Vanilla-website-utils--module.exports+clear_textarea"></a>

### module.exports#clear\_textarea() ⏏
**Kind**: Exported function  
**Example**  
```js
var vwu = new Vanilla_website_utils();
vwu.clear_textarea()
```
<a name="exp_module_Vanilla-website-utils--module.exports+sort_object"></a>

### module.exports#sort\_object(obj, sort_order) ⇒ <code>array</code> ⏏
**Kind**: Exported function  

| Param | Type | Default | Description |
| --- | --- | --- | --- |
| obj | <code>object</code> |  | javascript object |
| sort_order | <code>string</code> | <code>&quot;desc&quot;</code> | desc or asc  (default desc) |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let obj = {a:100,b:50,c:75,d:1};
let a = vwu.sort_object('desc'); 
```
<a name="exp_module_Vanilla-website-utils--module.exports+from_112_to_date"></a>

### module.exports#from\_112\_to\_date(str, add_days) ⇒ <code>object</code> ⏏
**Kind**: Exported function  
**Returns**: <code>object</code> - - date object  

| Param | Type | Default | Description |
| --- | --- | --- | --- |
| str | <code>str</code> |  | a 112 string type date |
| add_days | <code>int</code> | <code>0</code> | add days or remove by adding -1 or 1 |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let date = vwu.112_to_date('20240601'); 
```
<a name="exp_module_Vanilla-website-utils--module.exports+date_to_112"></a>

### module.exports#date\_to\_112(_date) ⇒ <code>string</code> ⏏
**Kind**: Exported function  
**Returns**: <code>string</code> - - in 112 format like 20230515  

| Param | Type | Description |
| --- | --- | --- |
| _date | <code>object</code> | dateobject |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let date = new Date();
let iso_112 = vwu.date_to_112(date); 
```
<a name="exp_module_Vanilla-website-utils--module.exports+month_list"></a>

### module.exports#month\_list(month_back, revert, format) ⇒ <code>arry</code> ⏏
**Kind**: Exported function  
**Returns**: <code>arry</code> - - list of month in format like 10.2022  

| Param | Type | Default | Description |
| --- | --- | --- | --- |
| month_back | <code>int</code> | <code>12</code> | number of month back |
| revert | <code>bolean</code> | <code>false</code> | revert order - Default is false |
| format | <code>string</code> | <code>&quot;&#x60;${j}.${i}&#x60;&quot;</code> | return format of the month year pair - Default {j}.{i} like 09.2022 | j = month | i =year | |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let data = await vwu.month_list(60,true,"`${j}.${i}`");
```
<a name="exp_module_Vanilla-website-utils--module.exports+get_host"></a>

### module.exports#get\_host(ext) ⇒ <code>string</code> ⏏
**Kind**: Exported function  
**Returns**: <code>string</code> - - the hostname  

| Param | Type | Default | Description |
| --- | --- | --- | --- |
| ext | <code>string</code> | <code>&quot;html&quot;</code> | extentison |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let host = await vwu.get_host();
```
<a name="exp_module_Vanilla-website-utils--module.exports+get_parameters"></a>

### module.exports#get\_parameters(url) ⇒ <code>object</code> ⏏
**Kind**: Exported function  
**Returns**: <code>object</code> - json pair key/value  

| Param | Type | Description |
| --- | --- | --- |
| url | <code>string</code> | url |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let v = await vwu.get_parameters();
```
<a name="exp_module_Vanilla-website-utils--module.exports+get_select_text_by_value"></a>

### module.exports#get\_select\_text\_by\_value(select, value) ⇒ <code>string</code> ⏏
**Kind**: Exported function  
**Returns**: <code>string</code> - text  

| Param | Type | Description |
| --- | --- | --- |
| select | <code>object</code> | the DOM select object |
| value | <code>string</code> | value |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let mytext = await vwu.get_select_text_by_value(document.querySelector("#resource"), v['resource'],v['resource']);
```
<a name="exp_module_Vanilla-website-utils--module.exports+add_parameters"></a>

### module.exports#add\_parameters(url, parameters) ⇒ <code>string</code> ⏏
**Kind**: Exported function  
**Returns**: <code>string</code> - url plus the new parameters  

| Param | Type | Description |
| --- | --- | --- |
| url | <code>string</code> | original url |
| parameters | <code>string</code> | json like {'foo':'bar'} |

**Example**  
```js
var vwu = new Vanilla_website_utils();
filter = {"foo":"bar"};
url = await vwu.add_parameters(url, filter);
```
<a name="exp_module_Vanilla-website-utils--module.exports+aget_api"></a>

### module.exports#aget\_api(url, user, password, token) ⇒ <code>object</code> ⏏
**Kind**: Exported function  
**Returns**: <code>object</code> - json  

| Param | Type | Description |
| --- | --- | --- |
| url | <code>string</code> | api url |
| user | <code>string</code> | user - for Basic Authorization |
| password | <code>string</code> | password - for Basic Authorization |
| token | <code>string</code> | token - for Bearer Authorization |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let res = await vwu.aget_api(url);
```
<a name="exp_module_Vanilla-website-utils--module.exports+aput_api"></a>

### module.exports#aput\_api(url, data, content_type) ⇒ <code>object</code> ⏏
**Kind**: Exported function  
**Returns**: <code>object</code> - json  

| Param | Type | Default | Description |
| --- | --- | --- | --- |
| url | <code>string</code> |  | api url |
| data | <code>object</code> |  | data |
| content_type | <code>string</code> | <code>&quot;application/json&quot;</code> | content type of the sending data optional - default is "application/json" |

**Example**  
```js
let data = {"foo":"bar"}
var vwu = new Vanilla_website_utils();
let res = await vwu.apost_api(url, data, "application/json");
```
<a name="exp_module_Vanilla-website-utils--module.exports+apost_api"></a>

### module.exports#apost\_api(url, data, content_type) ⇒ <code>object</code> ⏏
**Kind**: Exported function  
**Returns**: <code>object</code> - json  

| Param | Type | Default | Description |
| --- | --- | --- | --- |
| url | <code>string</code> |  | api url |
| data | <code>object</code> |  | data |
| content_type | <code>string</code> | <code>&quot;application/json&quot;</code> | content type of the sending data optional - default is "application/json" |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let res = await vwu.apost_api(url, data, "application/json");
```
<a name="exp_module_Vanilla-website-utils--module.exports+post_api"></a>

### module.exports#post\_api(url, my_callback, _data) ⇒ <code>object</code> ⏏
**Kind**: Exported function  
**Returns**: <code>object</code> - json  

| Param | Type | Description |
| --- | --- | --- |
| url | <code>string</code> | api url |
|  | <code>object</code> | data |
| my_callback | <code>string</code> | name of the callback function |
| _data | <code>string</code> | content type of the sending data optional - default is "application/json" |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let data = {"foo":"bar"}
let ret = vwu.post_api('http://foo.bar/api','myfuncion','application/json') 
```
<a name="exp_module_Vanilla-website-utils--module.exports+_email_validator"></a>

### module.exports#\_email\_validator(email) ⇒ <code>bolan</code> ⏏
**Kind**: Exported function  
**Returns**: <code>bolan</code> - true if ok and false if bad email  

| Param | Type | Description |
| --- | --- | --- |
| email | <code>string</code> | email |

**Example**  
```js
var vwu = new Vanilla_website_utils();
const ok = vwu._email_validator(foo@bar.com)
```
<a name="exp_module_Vanilla-website-utils--module.exports+email_validator"></a>

### module.exports#email\_validator(email) ⇒ <code>bolan</code> ⏏
**Kind**: Exported function  
**Returns**: <code>bolan</code> - true if ok and false if bad email  

| Param | Type | Description |
| --- | --- | --- |
| email | <code>string</code> | email |

**Example**  
```js
var vwu = new Vanilla_website_utils();
const ok = await vwu._email_validator(foo@bar.com)
```
<a name="exp_module_Vanilla-website-utils--module.exports+get_url_parameter"></a>

### module.exports#get\_url\_parameter(name) ⇒ <code>string</code> ⏏
**Kind**: Exported function  
**Returns**: <code>string</code> - url parameter  

| Param | Type | Description |
| --- | --- | --- |
| name | <code>string</code> | key of the url parameter |

**Example**  
```js
var vwu = new Vanilla_website_utils();
const from = await vwu.get_url_parameter('from')
```
<a name="exp_module_Vanilla-website-utils--module.exports+get_site"></a>

### module.exports#get\_site() ⇒ <code>string</code> ⏏
**Kind**: Exported function  
**Returns**: <code>string</code> - sitename  
**Example**  
```js
var vwu = new Vanilla_website_utils();
let site = vwu.get_site
```
<a name="exp_module_Vanilla-website-utils--module.exports+autocomplete_textfield"></a>

### module.exports#autocomplete\_textfield(setting, search) ⏏
**Kind**: Exported function  

| Param | Type | Description |
| --- | --- | --- |
| setting | <code>object</code> | see example |
| search |  | in object can be begining(default) or inline |

**Example**  
```js
var vwu = new Vanilla_website_utils();
 await vwu.autocomplete_textfield({
     url: api + '/code/name',
       onetimeload: true,
       dom_id: 'search',
       name: 'search',
       append_to: '#nav-search',
       min_key_length: 2
       search: inline
     });
     url: api + '/code/name',
       onetimeload: true,
       dom_id: 'search',
       name: 'search',
       append_to: '#nav-search',
       min_key_length: 2
       search: beginning
     });
```
<a name="exp_module_Vanilla-website-utils--module.exports+autocomplete_select"></a>

### module.exports#autocomplete\_select(setting) ⏏
**Kind**: Exported function  

| Param | Type | Description |
| --- | --- | --- |
| setting | <code>object</code> | see example |

**Example**  
```js
var vwu = new Vanilla_website_utils();
 await vwu.autocomplete_select({
     url: api + '/code/name',
       onetimeload: true,
       dom_id: 'search',
       name: 'search',
     });
```
<a name="exp_module_Vanilla-website-utils--module.exports+_set_textfield"></a>

### module.exports#\_set\_textfield() ⏏
**Kind**: Exported function  
<a name="exp_module_Vanilla-website-utils--module.exports+autoload_textfield"></a>

### module.exports#autoload\_textfield() ⏏
**Kind**: Exported function  
<a name="exp_module_Vanilla-website-utils--module.exports+autocomplete"></a>

### module.exports#autocomplete() ⏏
**Kind**: Exported function  
<a name="exp_module_Vanilla-website-utils--module.exports+post_textfield_rows"></a>

### module.exports#post\_textfield\_rows(id, url, callback) ⇒ <code>callback</code> ⏏
**Kind**: Exported function  
**Returns**: <code>callback</code> - - callback call  

| Param | Type | Description |
| --- | --- | --- |
| id | <code>string</code> | id from a enbedded Textfield into a form tag |
| url | <code>string</code> | url string where to post the data rows |
| callback | <code>string</code> | callback function, you need to declare a callbackup what will be called after the post |

**Example**  
```js
it will disable the form submit 
var vwu = new Vanilla_website_utils();
let array= vwu.get_text_rows);
```
<a name="exp_module_Vanilla-website-utils--module.exports+get_form_data"></a>

### module.exports#get\_form\_data(form) ⇒ <code>array</code> ⏏
**Kind**: Exported function  
**Returns**: <code>array</code> - in key/value as JSON  

| Param | Type | Description |
| --- | --- | --- |
| form | <code>object</code> | form object |

**Example**  
```js
var vwu = new Vanilla_website_utils();
let data = JSON.stringify(await vwu.get_form_data(form));
```
<a name="exp_module_Vanilla-website-utils--module.exports+s_fill_select"></a>

### module.exports#s\_fill\_select(select_obj, data) ⏏
**Kind**: Exported function  

| Param | Type | Description |
| --- | --- | --- |
| select_obj | <code>object</code> | DOM object |
| data | <code>object</code> | data array |

**Example**  
```js
var vwu = new Vanilla_website_utils();
 let extra_sel = document.querySelector("#extra");
 await vwu.fill_select(extra_sel, data);
```
<a name="exp_module_Vanilla-website-utils--module.exports+fill_select"></a>

### module.exports#fill\_select(select_obj, data, selected, copy2clipboard, log) ⏏
**Kind**: Exported function  

| Param | Type | Default | Description |
| --- | --- | --- | --- |
| select_obj | <code>object</code> |  | DOM object |
| data | <code>object</code> |  | data array |
| selected | <code>string</code> |  | select element |
| copy2clipboard | <code>boolean</code> | <code>false</code> | copy2clipboard true or false |
| log | <code>object</code> | <code>false</code> | log object - experimental |

**Example**  
```js
var vwu = new Vanilla_website_utils();
const url = api + '/fields?table=av0_style&db=sl&server=232&f=list';
const data = JSON.parse(await aget_api(url));
let extra_sel = document.querySelector("#extra");
await vwu.fill_select(extra_sel, data);
await vwu.fill_select(sel,all_tags,'height: 500px; width: 230px;font-size: 9px',true, log);
```
<a name="exp_module_Vanilla-website-utils--module.exports+pad"></a>

### module.exports#pad(number) ⇒ <code>string</code> ⏏
**Kind**: Exported function  
**Returns**: <code>string</code> - - data array  

| Param | Type | Description |
| --- | --- | --- |
| number | <code>int</code> | number |

**Example**  
```js
var vwu = new Vanilla_website_utils();
 let x = vwu.pad(5);
```
<a name="exp_module_Vanilla-website-utils--module.exports+s_set_selected"></a>

### module.exports#s\_set\_selected(select_obj, data) ⏏
**Kind**: Exported function  

| Param | Type | Description |
| --- | --- | --- |
| select_obj | <code>object</code> | DOM object |
| data | <code>object</code> | data array |

**Example**  
```js
var vwu = new Vanilla_website_utils();
 let extra_sel = document.querySelector("#extra");
 await vwu.fill_select(extra_sel, data);
```
<a name="exp_module_Vanilla-website-utils--module.exports+set_selected"></a>

### module.exports#set\_selected() ⏏
**Kind**: Exported function  
**Example**  
```js
var vwu = new Vanilla_website_utils(); 
let select = document.querySelector("#bom");
await vwu.set_selected(select,v['bom']);
```

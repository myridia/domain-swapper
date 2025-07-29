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

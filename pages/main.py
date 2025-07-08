#!/usr/bin/env python
from jinja2 import Environment, FileSystemLoader, select_autoescape


env = Environment(loader=FileSystemLoader("templates"), autoescape=select_autoescape())
template = env.get_template("index.html")
buf = template.render(name="Pages")
out_path = "public/index.html"


with open(out_path, "w") as f:
    f.write(buf)

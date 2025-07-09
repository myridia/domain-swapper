#!/usr/bin/env python
import platform, time, json, csv, datetime
from pathlib import Path
import requests, argparse
import couchdb2
from jinja2 import Environment, FileSystemLoader, select_autoescape

env = Environment(loader=FileSystemLoader("templates"), autoescape=select_autoescape())


class MakePages:
    def __init__(self):
        print("...init MakePages")
        p = Path("db/page.json")
        doc = {}
        if p.is_file():
            j = p.read_text()
            doc = json.loads(j)
        else:
            server = couchdb2.Server("https://cb.neriene.com")
            db = server.get("domain_swapper")
            doc = db.get("page")

            with open("db/page.json", "w") as f:
                f.write(json.dumps(doc))
        self.company = doc["company"]
        self.templates = doc["templates"]
        self.menu = doc["menu"]

        """
        self.templates = [
            "index.html",
            "contact.html",
            "faq.html",
            "install.html",
            "terms.html",
        ]
        self.menu = [
            {"href": "index.html", "name": "Home"},
            {"href": "install.html", "name": "Install"},
            {"href": "faq.html", "name": "FAQ"},
            {"href": "docs/index.html", "name": "Documentation"},
            {"href": "terms.html", "name": "Terms & Info"},
            {"href": "contact.html", "name": "Contact"},
        ]

        self.company = "Domain Swapper"
        """

    def start(self):
        print("...start")
        for i in self.templates:
            print("...generate {0}".format(i))
            template = env.get_template(i)
            buff = template.render(name=i, menu=self.menu, company=self.company)
            out_path = "public/{}".format(i)
            with open(out_path, "w") as f:
                f.write(buff)


if __name__ == "__main__":
    parser = argparse.ArgumentParser(
        prog="MakePages",
        description="Generate Pages",
        epilog="Text at the bottom of help",
    )
    mp = MakePages()
    mp.start()

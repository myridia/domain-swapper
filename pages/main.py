#!/usr/bin/env python
import platform, time, json, csv, datetime
import requests, argparse

from jinja2 import Environment, FileSystemLoader, select_autoescape

env = Environment(loader=FileSystemLoader("templates"), autoescape=select_autoescape())


class MakePages:
    def __init__(self):
        print("...init MakePages")
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

#!/usr/bin/env python
import platform, time, json, csv, datetime
from pathlib import Path
import requests, argparse
import couchdb2
from jinja2 import Environment, FileSystemLoader, select_autoescape
from datetime import datetime


env = Environment(
    loader=FileSystemLoader("templates"),
    autoescape=select_autoescape(),
    extensions=["jinja2.ext.i18n"],
)
env.add_extension("jinja2.ext.debug")


class MakePages:
    def __init__(self):
        print("...init MakePages")
        self.server_name = "https://cb.neriene.com"
        self.db_name = "domain_swapper"
        self.cache = True
        self.target_folder = "public"
        self.templates = self.get_doc("templates")
        print(self.templates)
        # self.remove_doc("page")
        # page = self.get_doc("page")
        # self.save_doc(page)

        # self.doc = doc

    def render_page(self, doc, template):
        print("...render_page")
        template = env.get_template(template)
        buff = template.render(doc=doc, template=template.replace(".html", ""))
        out_path = "{0}/{1}".format(self.target_folder, template)
        with open(out_path, "w") as f:
            f.write(buff)

    def get_doc(self, id):
        doc = {}
        p = Path("db/{}.json".format(id))
        if p.is_file():
            j = p.read_text()
            doc = json.loads(j)
        else:
            doc = self.download_doc(id)
            if self.cache == True:
                self.save_doc(doc)
        return doc

    def download_doc(self, id):
        server = couchdb2.Server(self.server_name)
        db = server.get(self.db_name)
        doc = db.get(id)
        return doc

    def save_doc(self, doc):
        p = Path("db/{}.json".format(doc["_id"]))
        with open("db/{}".format(p.name), "w") as f:
            f.write(json.dumps(doc))

    def remove_doc(self, id):
        p = Path("db/{}.json".format(id))
        if p.is_file():
            p.unlink()


if __name__ == "__main__":
    parser = argparse.ArgumentParser(
        prog="MakePages",
        description="Generate Pages",
        epilog="Text at the bottom of help",
    )
    mp = MakePages()
    # mp.start()

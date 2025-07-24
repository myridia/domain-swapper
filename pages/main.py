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
        self.cache = False
        self.target_folder = "public"
        self.template_folder = "templates"
        self.templates = []
        self.page = []

    def render_templates(self, _templates=[]):
        templates = []
        if len(_templates):
            templates = _templates
        templates = self.templates
        print("...render templates")
        for i in templates:
            doc = self.get_doc(i)
            self.render_page(doc, i)

    def render_page(self, doc, template_file):
        p = Path("{0}/{1}".format(self.template_folder, template_file))
        print("...try render page {0}".format(p))
        if p.is_file():
            print("...ok...template exists")
            template = env.get_template(template_file)
            buff = template.render(
                doc=doc, page=self.page, template=template_file.replace(".html", "")
            )
            out_path = "{0}/{1}".format(self.target_folder, template_file)
            with open(out_path, "w") as f:
                f.write(buff)

    def get_doc(self, _id):
        print("...get doc {0}".format(_id))
        id = _id.split(".")[0]
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
        print("...download doc {0}".format(id))
        server = couchdb2.Server(self.server_name)
        db = server.get(self.db_name)
        doc = db.get(id)
        return doc

    def save_doc(self, doc):
        print("...save doc {0}".format(doc["_id"]))
        p = Path("db/{}.json".format(doc["_id"]))
        with open("db/{}".format(p.name), "w") as f:
            f.write(json.dumps(doc))

    def remove_doc(self, id):
        print("...remove doc {0}".format(id))
        p = Path("db/{}.json".format(id))
        if p.is_file():
            p.unlink()

    def set_cache(self):
        print("...set_cache")
        self.cache = True

    def unset_cache(self):
        print("...unset_cache")
        self.cache = False

    def remove_rendered(self):
        print("...remove rendered")
        self.cache = False


if __name__ == "__main__":
    parser = argparse.ArgumentParser(
        prog="MakePages",
        description="Generate Pages",
        epilog="Text at the bottom of help",
    )
    m = MakePages()
    m.page = m.get_doc("page")
    m.templates = m.page["templates"]
    m.render_templates(m.templates)
    m.render_page(m.page, "assets/css/styles.css")
    m.render_page(m.page, "assets/js/page.js")

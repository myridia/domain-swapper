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
        self.remove_doc("page")
        page = self.get_doc("page")
        self.save_doc(page)
        # print(page)
        # self.doc = doc

    def start(self):
        print("...start")
        for i in self.doc["templates"]:
            print("...generate {0}".format(i))
            template = env.get_template(i)
            buff = template.render(doc=self.doc, template=i.replace(".html", ""))
            out_path = "public/{}".format(i)
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

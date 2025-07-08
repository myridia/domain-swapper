#!/usr/bin/env python
import platform, time, json, csv, datetime
import requests, argparse

from jinja2 import Environment, FileSystemLoader, select_autoescape

env = Environment(loader=FileSystemLoader("templates"), autoescape=select_autoescape())


class MakePages:
    def __init__(self):
        print("...init MakePages")

    def start(self):
        print("...start")
        template = env.get_template("index.html")
        buff = template.render(name="Pages")
        out_path = "public/index.html"
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

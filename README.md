# Terminus Omniscient Plugin

[![Terminus v1.x Compatible](https://img.shields.io/badge/terminus-v1.x-green.svg)](https://github.com/terminus-plugin-project/terminus-omniscient-plugin/tree/1.x)
[![Terminus v0.x Compatible](https://img.shields.io/badge/terminus-v0.x-green.svg)](https://github.com/terminus-plugin-project/terminus-omniscient-plugin/tree/0.x)

Terminus plugin to enable [New Relic Pro](https://pantheon.io/docs/new-relic/) on all [Pantheon](https://www.pantheon.io) sites.

Adds a sub-command to 'sites' which is called 'omniscient'. This enables New Relic Pro for all sites your account has access to.

## Installation
To install this plugin, create a plugins folder in `~/.terminus/` if you don't already have one, download and extract the files into the plugins folder `~/.terminus/plugins/`.

## Run
* `terminus sites:omniscient`
In Terminus enter: terminus sites:omniscient to enabled New Relic Pro for all the sites in your account, frozen and sites that has already been enabled manually will be skipped. 

On Mac OS/Linux:
```
mkdir -p ~/.terminus/plugins
composer create-project -d ~/.terminus/plugins terminus-plugin-project/terminus-omniscient-plugin:~1
```
For additional help installing, see [Terminus' Plugins](https://pantheon.io/docs/terminus/plugins/).

## Help
Run `terminus help omniscient` for help.

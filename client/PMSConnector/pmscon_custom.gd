# * Php mysql connector - PMSC PLUGIN to server connections with godot
# * revised version on 29/12/2017 
# * written by jonas wesley, Version 2.7
# * 
# * "Everything can connect, everything can be connected."
# * 
# * Copyright (C) 2017  Lights On
# *
# * This program is free software; you can redistribute it and/or modify
# * it under the terms of the GNU General Public License as published by
# * the Free Software Foundation; either version 2 of the License or other latest 
# * version.
# *
# * This program is distributed in the hope that it will be useful,
# * but WITHOUT ANY WARRANTY; without even the implied warranty of
# * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# * GNU General Public License for more details.

tool
extends EditorPlugin

func _enter_tree():
	add_custom_type("PMSConnector", "Node", preload("pmsconPlugin.gd"), preload("icon.png"))

func _exit_tree():
	remove_custom_type("PMSConnector")

# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

    config.vm.box = "scotch/box"
    config.vm.network "private_network", ip: "192.168.33.10"
    config.vm.hostname = "55hubs"

    config.vm.provision "shell", path: "vagrant_provison.sh", privileged: false

    config.vm.synced_folder "../55hubs-themes", "/55hubs-themes"

end

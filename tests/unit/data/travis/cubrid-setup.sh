#!/bin/sh
#
# install CUBRID DBMS https://github.com/CUBRID/node-cubrid/blob/056e734ce36bb3fd25f100c983beb3947e899c1c/.travis.yml

sudo hostname localhost
# Update OS before installing prerequisites.
sudo apt-get update
# Install Chef Solo prerequisites.
sudo apt-get install ruby ruby-dev libopenssl-ruby rdoc ri irb build-essential ssl-cert
# Install Chef Solo.
# Chef Solo 11.4.4 is broken, so install a previous version.
# The bug is planned to be fixed in 11.4.5 which haven't been released yet.
sudo gem install --version '<11.4.4' chef --no-rdoc --no-ri
# Make sure the target directory for cookbooks exists.
mkdir -p /tmp/chef-solo
# Prepare a file with runlist for Chef Solo.
echo '{"cubrid":{"version":"'$CUBRID_VERSION'"},"run_list":["cubrid::demodb"]}' > cubrid_chef.json
# Install CUBRID via Chef Solo. Download all cookbooks from a remote URL.
sudo chef-solo -c tests/unit/data/travis/cubrid-solo.rb -j cubrid_chef.json -r http://sourceforge.net/projects/cubrid/files/CUBRID-Demo-Virtual-Machines/Vagrant/chef-cookbooks.tar.gz/download


install_pdo_cubrid() {
    wget "http://pecl.php.net/get/PDO_CUBRID-9.1.0.0003.tgz" &&
    tar -zxf "PDO_CUBRID-9.1.0.0003.tgz" &&
    sh -c "cd PDO_CUBRID-9.1.0.0003 && phpize && ./configure && make && sudo make install"

    echo "extension=pdo_cubrid.so" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini

    return $?
}

install_pdo_cubrid > ~/pdo_cubrid.log || ( echo "=== PDO CUBRID BUILD FAILED ==="; cat ~/pdo_cubrid.log )
---
title: Remote Visual Studio Code With code-server
date: 2020-04-13
layout: post
---

Getting [code-server](https://github.com/cdr/code-server/) set up with Ubuntu 18.04 was a little tricky as their docs don't really get into the details of how to set things up... at all. So here's how to set up `code-server` on Ubuntu 18.04 on your own domain.

## 0. set up Ubuntu 18.04

I won't get into the details here. My setup is a Digital Ocean droplet with 2 CPU and 2 GB of ram.

## 1. get the latest release of code-server

copy the link for the [latest release](https://github.com/cdr/code-server/releases). the `<release>` placeholder should be replaced with the current release of code-server.

```
wget https://github.com/cdr/code-server/releases/download/<release>/code-server-<release>-linux-x86_64.tar.gz
```

untar the release

```
tar -xf code-server-<release>-linux-x86_64.tar.gz
```

move the directory to something friendlier

```
mv code-server-<release>-linux-x86_64 .code-server
```

## 2. make the directories we'll need later

```
mkdir .code-server/extensions
mkdir .code-server/user-data
```

## 3. configure nginx

### 3.1 follow [this guide](https://www.digitalocean.com/community/tutorials/how-to-create-a-self-signed-ssl-certificate-for-nginx-in-ubuntu-18-04)

This will set you up with a basic nginx server with a self-signed cert.

You can either use another service to terminal TLS (I use Cloudflare), or you can generate your own certs with [Lets Encrypt](https://www.digitalocean.com/community/tutorials/how-to-secure-nginx-with-let-s-encrypt-on-ubuntu-18-04), I won't be going into how to do either of those here.

Note: there is a line in `ssl-params.conf` that will prevent Module previews from working. If you so choose, you can delete this line:

```
add_header X-Frame-Options DENY;
```

### 3.2 modify your nginx config

we need to add a `location` block to your `/etc/nginx/sites-available/<your domain>`. Edit that file and add:

```
server {
	... code from guide above

	# Forward all connections to code-server
	location / {
		proxy_pass http://127.0.0.1:8181;
		proxy_http_version 1.1;
		proxy_set_header Upgrade $http_upgrade;
		proxy_set_header Connection "upgrade";
		proxy_set_header Host $host;
	}
}
```

tell nginx to use it

```
sudo ln -s /etc/nginx/sites-available/<domain> /etc/nginx/sites-enabled/<domain>
```

restart nginx

```
sudo systemctl restart nginx
```

## 4. set up a service

save this to a file called `code-server.service` in your home directory, replacing `<your user>` with your ubuntu user.

```
[Unit]
Description=VSCode Code Server

[Service]
Type=simple
User=<your user>
Group=<your user>
Environment=PASSWORD=changeme
ExecStart=/bin/bash /home/<your user>/.code-server/code-server --host 127.0.0.1 --port 8181 --disable-ssh --user-data-dir /home/<your user>/.code-server/user-data --extensions-dir /home/<your user>/.code-server/extensions

[Install]
WantedBy=multi-user.target
```

move the file so that systemd knows about it

```
sudo cp ~/code-server.service /etc/systemd/system/code-server.service
```

enable it to start when the server starts

```
sudo systemctl enable code-server
```

start the service

```
sudo systemctl start code-server
```

## 5. point dns at your server.

In Cloudflare add a dns entry that points to your server. This can be anything you want, currently I use a subdomain of the domain this page is on.

Whatever you pick, the url will be password protected by the configuration above (see `Environment=PASSWORD=changeme` above).

## 6. go to the url

Visit the url that you set in the set above. The password (unless you changed it) will be `changeme`. Please change this.

That's it! You've got a remove Visual Studio Code instance that you can use from anywhere.

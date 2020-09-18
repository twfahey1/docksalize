<?php

# Docksal DB connection settings.
$databases['default']['default'] = array (
  'database' => getenv('MYSQL_DATABASE'),
  'username' => getenv('MYSQL_USER'),
  'password' => getenv('MYSQL_PASSWORD'),
  'host' => getenv('MYSQL_HOST'),
  'driver' => 'mysql',
);
# File system settings.
$conf['file_temporary_path'] = '/tmp';
# Workaround for permission issues with NFS shares
$conf['file_chmod_directory'] = 0777;
$conf['file_chmod_file'] = 0666;
# Reverse proxy configuration (Docksal vhost-proxy)
if (!drupal_is_cli()) {
  $conf['reverse_proxy'] = TRUE;
  $conf['reverse_proxy_addresses'] = array($_SERVER['REMOTE_ADDR']);
  // HTTPS behind reverse-proxy
  if (
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' &&
    !empty($conf['reverse_proxy']) && in_array($_SERVER['REMOTE_ADDR'], $conf['reverse_proxy_addresses'])
  ) {
    $_SERVER['HTTPS'] = 'on';
    // This is hardcoded because there is no header specifying the original port.
    $_SERVER['SERVER_PORT'] = 443;
  }
}

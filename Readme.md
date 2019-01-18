Se agrega la siguiente columna:

``
alter table apartamento add column hash varchar(255);
``

y se popula haciendo:

``
update apartamento set hash = md5(url);
``
CREATE TABLE `refpath` (
  `id_refpath` int(11) NOT NULL,
  `libelle_refpath` varchar(25) NOT NULL,
  `path_refpath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `refpath`
  ADD PRIMARY KEY (`id_refpath`);
  
ALTER TABLE `refpath`
  MODIFY `id_refpath` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `refpath` (`id_refpath`, `libelle_refpath`, `path_refpath`) VALUES (NULL, 'src', '~/Documents/MNHN-Cloud/');



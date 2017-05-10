#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: t_atelier_niv3
#------------------------------------------------------------

CREATE TABLE t_atelier_niv3(
        idAtelierNiv3 int (11) Auto_increment  NOT NULL ,
        ateNom        Varchar (25) NOT NULL ,
        idAtelierNiv2 Int NOT NULL ,
        PRIMARY KEY (idAtelierNiv3 )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_atelier_niv2
#------------------------------------------------------------

CREATE TABLE t_atelier_niv2(
        idAtelierNiv2    int (11) Auto_increment  NOT NULL ,
        ateNom           Varchar (25) NOT NULL ,
        idAtelierNiveau1 Int NOT NULL ,
        PRIMARY KEY (idAtelierNiv2 )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_travailleur
#------------------------------------------------------------

CREATE TABLE t_travailleur(
        idTravailleur  int (11) Auto_increment  NOT NULL ,
        traNom         Varchar (25) NOT NULL ,
        traPrenom      Varchar (25) NOT NULL ,
        traPourcentage Int NOT NULL ,
        idMSP          Int NOT NULL ,
        PRIMARY KEY (idTravailleur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_atelier_niv1
#------------------------------------------------------------

CREATE TABLE t_atelier_niv1(
        idAtelierNiveau1 int (11) Auto_increment  NOT NULL ,
        ateNom           Varchar (25) NOT NULL ,
        idCouleur        Int NOT NULL ,
        PRIMARY KEY (idAtelierNiveau1 )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_couleur
#------------------------------------------------------------

CREATE TABLE t_couleur(
        idCouleur          int (11) Auto_increment  NOT NULL ,
        couNomCouleur      Varchar (25) NOT NULL ,
        couCodeHexadecimal Varchar (40) NOT NULL ,
        PRIMARY KEY (idCouleur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_MSP
#------------------------------------------------------------

CREATE TABLE t_MSP(
        idMSP        int (11) Auto_increment  NOT NULL ,
        mspNom       Varchar (25) NOT NULL ,
        mspPrenom    Varchar (25) NOT NULL ,
        mspInitiales Varchar (4) NOT NULL ,
        PRIMARY KEY (idMSP )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_tache
#------------------------------------------------------------

CREATE TABLE t_tache(
        taDate        Date ,
        taEstMatin    Bool ,
        idAtelierNiv3 Int NOT NULL ,
        idTravailleur Int NOT NULL ,
        PRIMARY KEY (idAtelierNiv3 ,idTravailleur )
)ENGINE=InnoDB;

ALTER TABLE t_atelier_niv3 ADD CONSTRAINT FK_t_atelier_niv3_idAtelierNiv2 FOREIGN KEY (idAtelierNiv2) REFERENCES t_atelier_niv2(idAtelierNiv2);
ALTER TABLE t_atelier_niv2 ADD CONSTRAINT FK_t_atelier_niv2_idAtelierNiveau1 FOREIGN KEY (idAtelierNiveau1) REFERENCES t_atelier_niv1(idAtelierNiveau1);
ALTER TABLE t_travailleur ADD CONSTRAINT FK_t_travailleur_idMSP FOREIGN KEY (idMSP) REFERENCES t_MSP(idMSP);
ALTER TABLE t_atelier_niv1 ADD CONSTRAINT FK_t_atelier_niv1_idCouleur FOREIGN KEY (idCouleur) REFERENCES t_couleur(idCouleur);
ALTER TABLE t_tache ADD CONSTRAINT FK_t_tache_idAtelierNiv3 FOREIGN KEY (idAtelierNiv3) REFERENCES t_atelier_niv3(idAtelierNiv3);
ALTER TABLE t_tache ADD CONSTRAINT FK_t_tache_idTravailleur FOREIGN KEY (idTravailleur) REFERENCES t_travailleur(idTravailleur);

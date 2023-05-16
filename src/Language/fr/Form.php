<?php
/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
return [ 
    'activity' => [
        'Activity' => 'Activité',
        'delete_selected' => 'Supprimer sélectionné',
        'delete_selected_confirm' => 'Confirmer suppression de sélection',
        'delete_all' => 'Tout supprimer',
        'delete_all_confirm' => 'Confirmation tout supprimer',
    ],
    'logs' => [
        'level' => 'Niveau',
        'date' => 'Date',
        'content' => 'Contenu',
        'delete_file' => 'Supprimer fichier',
        'delete_confirm' => 'Confirmer la suppression',

        'LogsSystemList' => 'Liste des logs système',
    ],
    'auth' => [
        'login' => 'Connexion',
    ],
    'groups' => [
        'Capabilities' => 'Capacitées',
        'Select all' => 'Tout sélectionner',
        'AddBouton' => 'Ajouter bouton',
        'roles' => 'Rôles',
    ],
    'settings' => [
        'DisplayInitialsBasedOn' => 'Afficher les initiales basées sur:',
        'UseGravatarForAvatars' => 'Utiliser le Gravatar pour les avatars',
        'GravatarForDefaultStyle' => 'Gravatar pour le style par défaut',
        'Timezone' => 'Fuseau horaire',
        'Timeout (in seconds)' => "Délai d'expiration (en secondes)",
        'Persistant Connection?' => 'Connexion persistante ?',
        'AllowUsersToBeRemembered' => "Permettre aux utilisateurs d'être remémorés",
        'IfUncheckedOnlySuperadmin' => "Si cette case n'est pas cochée, seuls les super administrateurs et les groupes d'utilisateurs autorisés peuvent accéder au site",
        'RememberUsersForHowLong' => 'Se souvenir des utilisateurs pour combien de temps ?',
        'IfCheckedWillSendCodeViaEmail' => 'If checked, will send a code via email for them to confirm general application.',
        'Force2FACheckAfterLogin' => "Forcer l'authentification à deux facteurs après la connexion ?",
        '2FAIfCheckedWillSendCodeViaEmail' => "Si coché, leur enverra un code par e-mail pour confirmer l'application générale.",
        'minimumPasswordLength' => 'Longueur de mot de passe minimum',
        'AMinimumValueIsRecommended' => 'Une valeur minimale de 8 est suggérée. Une valeur de 10 est recommandée.',
        'CompositionValidator' => 'Validateur de la composition',
        'NothingPersonalValidator' => 'Validateur de rien de personnel',
        'NothingCompositionValidator' => "Validateur d'aucune composition",
        'DictionaryValidator' => 'Validateur de dictionnaire',
        'CompositionValidatorDesc' => 'Le validateur de composition vérifie principalement les exigences relatives à la longueur du mot de passe',
        'NothingPersonalValidatorDesc' => "Le 'Validateur de rien de personnel' vérifie les similitudes entre le mot de passe,l'email, le nom d'utilisateur et d'autres champs personnels pour s'assurer qu'ils ne sont pas trop similaires et faciles à deviner.",
        'NothingCompositionValidatorDesc' => 'Le "Validateur de dictionnaire" utilise un <a href="https://haveibeenpwned.com/Passwords" target="_blank">site tiers</a>
                        pour vérifier le mot de passe par rapport à des millions de mots de passe divulgués.',
        'PasswordsNote' => "REMARQUE : Vous ne devez sélectionner qu'un seul des validateurs Dictionary et Pwned.",
        'AllowUsersToRegister' => "Autoriser les utilisateur de s'inscrire sur le site",
        'IfUncheckedAdminWillNeed' => "Si décochée, un administrateur devra créer des utilisateurs.",
        'ForceEmailVerificationAfterRegistration' => "Forcer la vérification de l'email après l'inscription ?",
        'IfCheckedWillSendCodeViaEmailForThemToConfirm' => "Si coché, enverra un code par e-mail pour qu'ils confirment",
        'DefaultUserGroup' => "Groupe par défaut: ",
        'TheUserGroupNewlyRegisteredUsersAreMembersOf' => "Le groupe d'utilisateurs nouvellement enregistrés sont membres de",
        'TheseRulesDetermineHowSecurePassword' => 'Ces règles déterminent le degré de sécurité d\'un mot de passe',
        'ThisSpecifiesTheDefaultEmailAddressAndNnameThatWillBeUsedWhenSendingAnEmail' => "Ceci spécifie l'adresse électronique et le nom par défaut qui seront utilisés lors de l'envoi d'un courrier électronique.",
        'SelectTheProtocolUsedWhenSendingMailSMTP' => "Sélectionnez le protocole utilisé pour l'envoi de courrier. Le scénario le plus courant est l'utilisation du protocole SMTP.",
        'MailIsOnlyAvailableOnLinuxServers' => "Mail n'est disponible que sur les serveurs Linux. Il n'y a pas d'options", 
        'Force2FACheckAfterLogin' => "Forcer le contrôle 2FA après la connexion", 
        'Force2FACheckAfterLoginDesc' => "Si la case est cochée, un code sera envoyé par courrier électronique pour confirmation.",
    ],
    'general' => [
        'title' => 'Titre',
        'description' => 'Description',
        'country' => 'Pays',
        'save' => 'Sauvegarder',
        'Name' => 'Nom',
        'fromEmail' => 'Depuis email',
        'protocol' => 'Protocole',
        'mailPath' => 'Chemin du mail',
        'SMTPHost' => 'SMTPHost',
        'SMTPPort' => 'SMTPPort',
        'Other' => 'Autre',
        'Username' => "Nom d'utilisateur",
        'Password' => 'Mot de passe',
        'SMTPCrypto' => 'SMTPCrypto',
        'siteName' => 'Nom du site',
        'siteNameDesc' => 'Apparaît dans l\'administration et est disponible sur l\'ensemble du site.',
        'siteOnline' => 'Site en ligne',
        'siteOnlineDesc' => 'Si cette case n\'est pas cochée, seuls Superadmin et les groupes d\'utilisateurs autorisés peuvent accéder au site..',
        'delete' => 'Supprimer',
        'choisissezVotreValeur' => 'Choisissez votre valeur',

    ],
    'ShieldOAuthLang' => [
        'allow_login' => 'Autoriser la connexion',
        'allow_register' => 'Autoriser inscription',
        'Type_connect' => 'Type de connexion',
        'allow_login_google' => 'Autoriser la connexion google',
        'client_id' => 'Identifiant client',
        'client_secret' => 'Secret client',
        'allow_login_github' => 'Autoriser la connexion github',

    ],
    'time' => [
        'mm/dd/yyyy' => 'mm/jj/aaaa',
        'dd/mm/yyyy' => 'jj/mm/aaaa',
        'dd-mm-yyyy' => 'jj-mm-aaaa',
        'yyyy-mm-dd' => 'aaaa-mm-jj',
        'mm dd, yyyy' => 'mm jj, aaaa',
        '12 hour with AM/PM' => '12 heures avec AM/PM',
        '24 hour' => '24 heures',
    ],
    'tools' => [
        'NameTokens' => 'Jetons du nom',
        'tokencreate' => 'Créer jeton',
        'Tokens' => 'Jetons',
    ],
    'Bonfire' => [
        'lastModified' => 'Dernière modification',
        'fileSize' => 'Taille du fichier',

    ],
    'Core' => [
        'signOut' => 'Se déconnecter',
        'currentSession' => 'Session curente',
        'NoRecentData' => 'Pas de donnée récente',

    ],
    'users' => [
        'Capabilities' => 'Capacités',
        'currentPassword' => 'Mot de passe actuel',
        'newPassword' => 'Nouveau mot de passe',
        'confirmPassword' => 'Confirmer le mot de passe',
        'LOWERCASE' => 'Minuscule',
        'UPPERCASE' => 'Majuscule',
        'NUMBERS' => 'Nombres',
        'SYMBOLS' => 'Symboles',
        'first_name' => 'Prénom',
        'last_name' => 'Nom',
        'email' => 'Email',
        'TheUsersWillHaveToRverifyTheirEmailAddress' => 'Les utilisateurs vont devoir revérifier leur adresse mail si vous le changez ou vous pouvez le faire manuellement',
        'Account Type' => 'Type de compte',
        'change' => 'Changer',
        'Active' => 'Actif',
        'yes' => 'Oui',
        'no' => 'Non',
        'EmailVerified' => 'Email vérifié',
        'verifie' => 'Vérifier',
        'AccountCreated' => 'Compte créé',
        'LastUpdated' => 'Mis à jour pour la dernière fois',
        'UsersList' => 'Liste des utilisateurs',
        'changeRole' => 'Modifier le rôle',
        'passwordLength' => 'Longueur du mot de passe', 
        'TwoFactoAuthentification' => 'Authentification à deux facteurs'
    ]
];
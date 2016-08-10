<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   setup.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pdelefos <pdelefos@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2016/07/11 12:05:09 by pdelefos          #+#    #+#             */
/*   Updated: 2016/08/09 11:38:57 by pdelefos         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */
	include_once 'database.php';

	$bdd = host_connect();
	$create = $bdd->prepare("CREATE DATABASE IF NOT EXISTS db_camagru");
	$create->execute();

	$bdd = database_connect();
	$sql = "CREATE TABLE IF NOT EXISTS user (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL);";
	$create = $bdd->prepare($sql);
	$create->execute();
?>
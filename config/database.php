<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   database.php                                       :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: fifiblop <fifiblop@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2016/07/11 12:02:26 by pdelefos          #+#    #+#             */
/*   Updated: 2016/08/03 13:38:28 by fifiblop         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

	$DB_HOST = "mysql:host=localhost;port=8888";
	$DB_DSN = "mysql:host=localhost;port=8888;dbname=db_camagru";
	$DB_USER = "root";
	$DB_PASSWORD = "";

	function host_connect()
	{
		global $DB_HOST, $DB_USER, $DB_PASSWORD;
		echo $DB_HOST . PHP_EOL;
		try {
			$dbh = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
			$dbh->setAttribute(PDO::ERRMODE_EXCEPTION);
			return ($dbh);
		} catch (PDOException $e) {
			echo 'Connection failed : ' . $e->getMessage() . PHP_EOL;
		}
	}

	function database_connect()
	{
		global $DB_DSN, $DB_USER, $DB_PASSWORD;
		try {
			$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$dbh->setAttribute(PDO::ERRMODE_EXCEPTION);
			return ($dbh);
		} catch (PDOException $e) {
			echo 'Connection failed : ' . $e->getMessage() . PHP_EOL;
		}
	}

	host_connect();
?>

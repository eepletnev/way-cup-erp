<?php
   

//
//  Жекина Система Модулей 1.0
//      vk.com/zhekaognemet
//

//  Фабрика страниц:
  require_once('sys_pages.php');

//  
//  ***********************************************************************
//      Создаём массивы с аргументами для конструктора фабрики страниц:
//  ***********************************************************************
//
//  Важно! href должен ссылаться на папку с index.php модуля. 

//                                          Страницы в Навигации:
        $navBarPages   =    array(
            array(
              'href'  => 'dashboard',
              'class' => 'icon-th-list',
              'name'  => 'Дашборд'
            ),
            array(
              'href'  => 'crm',
              'class' => 'icon-user',
              'name'  => 'Клиенты'
            ),
            array(
              'href'  => 'sales',
              'class' => 'icon-shopping-cart',
              'name'  => 'Продажи'
            ),
            array(
              'href'  => 'exes.check',
              'class' => 'icon-tag',
              'name'  => 'Затраты'
            ),
            array(
              'href'  => 'menu',
              'class' => 'icon-align-justify',
              'name'  => 'Меню'
            ),
            array(
              'href'  => 'exes.products',
              'class' => 'icon-tags',
              'name'  => 'Продукты'
            ),
            array(
              'href'  => 'inventory',
              'class' => 'icon-home',
              'name'  => 'Склад'
            ),
            array(
              'href'  => 'finance',
              'class' => 'icon-lock',
              'name'  => 'Деньги'
            )
        );


//                                          Страницы для Админа:
        $adminPages   =    array(
            array(
              'href'  => 'admin',
              'class' => 'icon-wrench',
              'name'  => 'Админка'
            )
        );

//                                          Страницы обработки заказа/закупки:
        $orderPages   =    array(
            array(
              'href'  => 'order',
              'name'  => 'По карте'
            ),
            array(
              'href'  => 'order/subscribtion',
              'name'  => 'По абонементу'
            ),
            array(
              'href'  => 'exes.purchase',
              'name'  => 'Закупка'
            )
        );

//                                          Прочие страницы:
        $otherPages   =    array(
            array(
              'href'  => 'hr/profile',
              'name'  => 'Профиль'
            )
        );

//  ************************************************************
//    Превращаем массивы с аргументами в массивы со страницами:
//  ************************************************************

$tmp = array();

        foreach ($navBarPages as $page) {
          array_push($tmp, SysPageFactory::addPage('Navigation', $page['href'], $page['class'], $page['name']));
        }

$navBarPages = $tmp;

//

$tmp = array();

        foreach ($adminPages as $page) {
          $pageObj = SysPageFactory::addPage('Admin', $page['href'], '', $page['name']);
          if (SysApplication::$currentSession == 0) {
            $pageObj->block();
          } 
          array_push($tmp, $pageObj);
        }

$adminPages = $tmp;

//

$tmp = array();

        foreach ($orderPages as $page) {
          array_push($tmp, SysPageFactory::addPage('Order', $page['href'], '', $page['name']));
        }

$orderPages = $tmp;

//

$tmp = array();

        foreach ($otherPages as $page) {
          array_push($tmp, SysPageFactory::addPage('Other', $page['href'], '', $page['name']));
        }

$otherPages = $tmp;

//
  unset($tmp);
//

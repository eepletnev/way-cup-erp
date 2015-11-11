﻿    /** @jsx React.DOM */       React.initializeTouchEvents(true);        var TouchMixin = {      touched: false,      handleTouch: function(fn) {        this.touched = true;        typeof fn === 'string' ? this[fn]() : this.touchedOrClicked(fn);      },      handleClick: function(fn) {        if (this.touched) return this.touched = false;        typeof fn === 'string' ? this[fn]() : this.touchedOrClicked(fn);      }    };        var menuElement = React.createClass({    mixins: [TouchMixin],        touchedOrClicked: function(){            this.props.onClick(this.props.ref);        },         render: function(){            return (                    <li onClick={ this.handleClick } onTouchEnd={ this.handleTouch }>                        <span>{this.props.name}</span><strong>{this.props.quanity}</strong>                        <br/>                        {this.props.amount}{this.props.unit}                        <br/>                        <i>{this.props.price}&#8381;</i>                                            </li>                );        }    });    var menuAndOrder = React.createClass({        getInitialState: function(){            return { total: 0, menuElements: [], orderElements: [], menuCategories: []};        },                kEbenyam: function(){            var menuElements = this.state.menuElements;            menuElements.map(function(e){                e.quanity = 0            });            this.setState({menuElements: menuElements, orderElements: [], total: 0 });        },        proceed: function(){            var orderElements = this.state.orderElements;                if (confirm('Подтвердить?')) {                    var toParse = [];                    var idset = [];                             if (orderElements.length != 0) {                        for (var i = 0; i < orderElements.length; i++) {                            idset.push(orderElements[i].id);                            while (orderElements[i].quanity != 1){                                idset.push(orderElements[i].id);                                orderElements[i].quanity--;                            }                        }                    }                    barista = document.getElementById('barista_id').value;                    shop    = document.getElementById('shop_id').value;                    toParse = {idset:idset, barista:barista, shop:shop};                                        $.post( "api.php?action=saveOutcomeCheck", toParse, function(data) {                        var tooltip;                        var text;                        text    = document.getElementById('tooltipText');                        tooltip = document.getElementById('tooltip');                        tooltip.style.display = 'inline';                        text.innerHTML = data;                    });                this.kEbenyam();            }        },        componentDidMount: function(){             var self = this;            var url  = 'api.php?action=getProducts';            $.getJSON(url, function(result){                elements   = result.elements;                categories = result.categories;            if(!elements || !elements.length){                return;            }                var menuCategories = categories.map(function(c){                    return {                        id:   c[0],                        name: c[1]                    };                });                var menuElements = elements.map(function(p){                    return {                        id: p[0],                        name: p[1],                        price: p[2],                        category: p[3],                        amount: p[4],                        unit: p[5],                        quanity: 0                    };                });                self.setState({ menuElements: menuElements, menuCategories: menuCategories });            });        },        menuElementClick: function(id){            var orderElements     = this.state.orderElements,                menuElements      = this.state.menuElements,                total             = this.state.total,                inOrdersAlready   = false;            for (var i = 0; i < orderElements.length; i++) {                if (orderElements[i].id == id) {                        inOrdersAlready = true;                    break;                }            }            for (var i = 0; i < menuElements.length; i++) {                if (menuElements[i].id == id) {                    menuElements[i].quanity += 1;                    if (!inOrdersAlready){                        orderElements.push(menuElements[i]);                    }                    total += Number(menuElements[i].price);                    break;                }            }            this.setState({menuElements: menuElements, orderElements: orderElements, total: total});        },        orderElementClick: function(id){            var orderElements = this.state.orderElements,                menuElements  = this.state.menuElements,                total         = this.state.total;            for (var i = 0; i < orderElements.length; i++) {                if (orderElements[i].id == id) {                    total -= Number(orderElements[i].price);                    orderElements[i].quanity -= 1;                    if (orderElements[i].quanity == 0){                        orderElements.splice(i, 1);                    }                     break;                }            }            this.setState({menuElements: menuElements, orderElements: orderElements, total: total});        },        render: function(){            var self = this;            var menuCategories   = this.state.menuCategories;            var menuElements     = this.state.menuElements;                menuElements     = menuElements.map(function(s){                    return <menuElement ref={s.id} name={s.name} price={s.price} category={s.category} amount={s.amount} unit={s.unit} onClick={self.menuElementClick} />;                });                            var cats = [];            console.log(cats);            menuCategories.forEach(function(c){                console.log(c.id);                cats.push(new Array());                i = 1;                while (typeof(cats[c.id-i]) == 'undefined') {                    i++;                }                      var empty = true;                cats[c.id-i].push(<div className="category-separator"><br/><h5>{c.name}</h5><br/></div>);                    menuElements.forEach(function(e){                        if (c.id == e.props.category) {                            cats[c.id-i].push(e);                            empty = false;                        }                    });                    if (empty) { cats.splice([c.id-i]); }                });                           if(!menuElements.length){                menuElements = <div><br/><br/><p>Загрузка данных с сервера...</p></div>;            }            var orderElements = this.state.orderElements.map(function(s){                return <menuElement ref={s.id} name={s.name} price={(s.price*s.quanity).toFixed(2)} category={s.category} quanity={s.quanity} amount={s.amount*s.quanity} unit={s.unit} onClick={self.orderElementClick} />;            });            if(!orderElements.length){                orderElements = <div className="order-war"><i>Сформируйте заказ</i></div>;            }            return (                <div>                    <div className="menu-items">                        <ul id="list-of-items-in-stock">                            {cats}                        </ul>                        <div className="clear"></div>                    </div>                    <div className="order">                        <h3 className="main-title">Заказ</h3>                         <ul id="order-list">                            {orderElements}                            <div className="clear"></div>                        </ul>                        <strong>Сумма заказа: {this.state.total.toFixed(2)}</strong>&#8381                       <div className="order-buttons">                        <button onClick={this.kEbenyam}>Очистить заказ</button>                        <button onClick={this.proceed}>Подтвердить</button>                       </div>                    </div>                </div>            );        }    });        React.renderComponent(        <menuAndOrder/>,        document.getElementById('menu-react-mount')    );
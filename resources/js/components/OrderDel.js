import React from 'react';
import ReactDOM from 'react-dom';

function OrderDel(props) {
    return (
        
    <div className="col-1 align-self-center pl-2">
            <i className="fas fa-arrow-alt-circle-up fa-2x pr-4 d-block order-del-btn" onClick={props.handleItemUp}></i>
        <i className="fas fa-times-circle fa-2x d-block my-2 order-del-btn" onClick={props.handleItemDel}></i>
            <i className="fas fa-arrow-alt-circle-down fa-2x d-block order-del-btn" onClick={props.handleItemDown}></i>
    </div>
    );
}

export default OrderDel;
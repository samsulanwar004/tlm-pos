import React, { useState, useEffect, useRef, Fragment } from 'react';
import ReactDOM from 'react-dom';
 
const Pos = (props) => {
 
  const [orderId, setOrderId] = useState('');
  const [type, setType] = useState(0);
  const [orders, setOrders] = useState(Array());

  async function fetchOrderId(e) {
    e.preventDefault();

    setOrderId('')

    let orderOld = orders;
    let findOrder =  orderOld.find(r => r.order_id == orderId);

    if (typeof findOrder != 'undefined') return

    Swal.fire({
      title: 'Please Wait !',
      allowOutsideClick: false,
      onBeforeOpen: () => {
        Swal.showLoading()
      },
    });

    const response = await fetch("/pos/search_order/"+orderId);
    const {data, message} = await response.json();

    if (message == 'success') {
      orderOld = orderOld.concat(data)
      setOrders(orderOld)
      Swal.close()
    } else {
      Swal.close()
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Order not found!'
      })
    }
  }

  async function processOrder(e) {
    e.preventDefault();

    if (orders.length <= 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Opps...',
        text: 'Empty cart'
      })

      return
    }

    Swal.fire({
      title: 'Please Wait !',
      allowOutsideClick: false,
      onBeforeOpen: () => {
        Swal.showLoading()
      },
    });

    const headers = new Headers({
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    });

    const response = await fetch("/pos/process_order",
    {
      headers,
      method: "POST",
      body: JSON.stringify({
        type: type,
        orders: orders.map(r => {
          return r.order_id
        }),
      })
    });

    const {data, message} = await response.json();

    if (message == 'success') {
      Swal.close()
      Swal.fire({
        icon: 'success',
        title: 'Transaction',
        text: 'Success'
      })
      
      setOrders(Array())
      setType(0)
    } else {
      Swal.close()
      Swal.fire({
        icon: 'danger',
        title: 'Oops...',
        text: 'Something wrong!'
      })
    }
  }

  useEffect(() => {

  }, []);

  const total = () => {
    let tot = 0;
    for (var i = 0; i < orders.length; i++) {
      for (var j = 0; j < orders[i].orders.length; j++) {
        tot += orders[i].orders[j].price * orders[i].orders[j].qty;
      }
    }

    return tot;
  }

  return (
    <Fragment>
      <div className="container-fluid">
        <div className="row">
          <div className="col-md-12">
            <div className="card card-secondary">
              <div className="card-header">
                <h1 className="card-title invisible">Pos</h1>
              </div>
              <div className="card-body">
                <div className="row">
                  <div className="col-md-3">
                    <div className="form-group">
                      <label htmlFor="orderid">Order ID</label>
                      <input 
                        onChange={(e) => setOrderId(e.target.value)} 
                        onKeyDown={(e) => e.key == 'Enter' ? fetchOrderId(e) : '' } 
                        value={orderId} 
                        type="text" 
                        className="form-control" 
                        placeholder="Search Order ID"
                        autoFocus 
                      />
                    </div>
                  </div>
                  <div className="col-md-9 table-responsive">
                    <table className="table table-striped">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Price</th>
                          <th>Qty</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        {orders.map((data, key) => {
                          return data.orders.map((d, k) => {
                            return (
                              <tr key={k}>
                                <td>{d.product_name}</td>
                                <td>{d.price}</td>
                                <td>{d.qty}</td>
                                <td>{d.price * d.qty}</td>
                              </tr>
                            )
                          })
                        })}
                      </tbody>
                    </table>
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-3">
                      
                  </div>
                  <div className="row col-md-9">
                    <div className="col-md-6">
                      <p className="lead">Payment Methods:</p>
                      <div className="form-group">
                        <div className="form-check">
                          <input className="form-check-input" type="radio" onChange={() => setType(0)} checked={type == 0 ? true : false} />
                          <label className="form-check-label">Cash</label>
                        </div>
                        <div className="form-check">
                          <input className="form-check-input" type="radio" onChange={() => setType(1)} checked={type == 1 ? true : false} />
                          <label className="form-check-label">EDC</label>
                        </div>
                      </div>
                    </div>
                    <div className="col-md-6">
                      <div className="table-responsive">
                          <table className="table">
                              <tbody>
                                  <tr>
                                    <th style={{width: '50%'}}>Total:</th>
                                    <td>{total()}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="card-footer">
                <div className="float-right">
                  <button onClick={(e) => processOrder(e)} className="btn btn-primary btn-lg">Process</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
 
export default Pos

var root = document.getElementById('pos');
if (root) {
    ReactDOM.render(<Pos {...(root.dataset)}/>, root);
}
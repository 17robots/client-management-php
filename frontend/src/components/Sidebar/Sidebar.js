import React, { useState, useContext } from 'react'
import { useHistory } from 'react-router-dom'

import AuthContext from '../../context/auth-context'
import Modal from '../Modal/Modal'
import Backdrop from '../Backdrop/Backdrop'

const Sidebar = props => {

  // the state
  const history = useHistory()
  const auth = useContext(AuthContext)
  const [isLogin, setLogin] = useState(false)
  const [isAuthing, setAuthing] = useState(false)
  const [canAuth, setCanAuth] = useState(true)

  // for the inputs
  let firstnameEL = React.createRef()
  let lastnameEl = React.createRef()
  let usernameEl = React.createRef()
  let emailEl = React.createRef()
  let passwordEl = React.createRef()
  let userEl = React.createRef()

  const goHome = () => {
    history.push('/')
  }

  const goClients = () => {
    history.push('/clients')
  }

  const goProjects = () => {
    history.push('/projects')
  }

  const goInvoices = () => {
    history.push('/invoices')
  }

  const cancelAuth = () => {
    setAuthing(false)
  }

  const switchToLogin = () => {
    setLogin(true)
  }

  const switchToRegister = () => {
    setLogin(false)
  }

  const logout = () => {
    auth.logout()
    setCanAuth(true)
  }

  const login = () => {
    const body = {
      action: "login",
      options: userEl.current.value.includes('@') ? {
        email: userEl.current.value,
        password: passwordEl.current.value
      } : {
          username: userEl.current.value,
          password: passwordEl.current.value
        }
    }

    fetch('http://localhost/isp/project/controller/Controller.php', {
      method: 'POST',
      body: JSON.stringify(body),
      headers: {
        'Content-Type': 'application/json; charset=UTF-8'
      }
    })
      .then(res => res.json())
      .then(resData => {
        if (resData.error) {
          alert(resData.error)
        } else {
          auth.login(resData.token, resData.userId, resData.tokenExpiration)
          alert(resData.success)
          setAuthing(false)
          setCanAuth(false)
        }
      })
  }

  const register = () => {
    const body = {
      action: "addUser",
      username: usernameEl.current.value,
      email: emailEl.current.value,
      firstname: firstnameEL.current.value,
      lastname: lastnameEl.current.value,
      password: passwordEl.current.value
    }

    fetch('http://localhost/isp/project/controller/Controller.php', {
      method: 'POST',
      body: JSON.stringify(body),
      headers: {
        'Content-Type': 'application/json; charset=UTF-8'
      }
    })
      .then(res => res.json())
      .then(resData => {
        if (resData.error) {
          alert(resData.error)
        } else {
          alert(`Account Successfully Created ${resData.firstname}, please log in with your new credentials:
          Username: ${resData.username} or Email: ${resData.email}
          Password: ${resData.password}
        `)
          switchToLogin()
        }
      })
  }

  return (
    <div className="sidebar">
      <button className="sidebar__tab" onClick={goHome}>Home</button>
      <button className="sidebar__tab" onClick={goClients}>Clients</button>
      <button className="sidebar__tab" onClick={goProjects}>Projects</button>
      <button className="sidebar__tab" onClick={goInvoices}>Invoices</button>
      {canAuth && <button className="sidebar__tab" onClick={() => setAuthing(true)}>Log In/Sign Up</button>}
      {!canAuth && <button className="sidebar__tab" onClick={logout}>Log Out</button>}
      {isAuthing && canAuth && <Backdrop />}
      {
        isAuthing && canAuth && !isLogin &&
        <Modal
          title="Sign Up"
          canCancel
          canConfirm
          onCancel={cancelAuth}
          onConfirm={register}
          CancelText="Cancel"
          confirmText="Register"
        >
          <form>
            <div className="form-control">
              <label htmlFor="firstname">First Name</label>
              <input type="text" id="firstname" ref={firstnameEL} required />

              <label htmlFor="lastname">Last Name</label>
              <input type="text" id="lastname" ref={lastnameEl} required />
            </div>
            <div className="form-control">
              <label htmlFor="email">Email</label>
              <input type="email" id="email" ref={emailEl} required />
            </div>
            <div className="form-control">
              <label htmlFor="lastname">Username</label>
              <input type="phone" id="phone" ref={usernameEl} required />
            </div>
            <div className="form-control">
              <label htmlFor="lastname">Password</label>
              <input type="password" id="passwordRegister" ref={passwordEl} required />
            </div>
          </form>

          Already Registered? Click <button onClick={switchToLogin}>Here</button> To Log In
        </Modal>
      }
      {
        isAuthing && canAuth && isLogin &&
        <Modal
          title="Log In"
          canCancel
          canConfirm
          onCancel={cancelAuth}
          onConfirm={login}
          CancelText="Cancel"
          confirmText="Log In"
        >
          <form>
            <div className="form-control">
              <label htmlFor="firstname">Username or Email</label>
              <input type="text" id="userData" ref={userEl} required />
            </div>
            <div className="form-control">
              <label htmlFor="lastname">Password</label>
              <input type="password" id="phone" ref={passwordEl} required />
            </div>
          </form>

          Need An Account? Click <button onClick={switchToRegister}>Here</button> To Register
        </Modal>
      }
    </div>
  )
}

export default Sidebar
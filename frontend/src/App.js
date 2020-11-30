import React, { useState } from 'react';
import { BrowserRouter, Route, Redirect, Switch } from 'react-router-dom'
import HomePage from './pages/HomePage'
import ClientPage from './pages/Clients'
import ProjectPage from './pages/Projects'
import InvoicePage from './pages/InvoicePage'
import AuthContext from './context/auth-context'
import Sidebar from './components/Sidebar/Sidebar'

import './App.css';

function App() {
  const [token, setToken] = useState(null)
  const [userId, setUserId] = useState(null)

  // <Link to="route" target="_blank" onClick={(event) => {event.preventDefault(); window.open(this.makeHref("route"));}} />

  const login = (token, userId, tokenExpiration) => {
    setToken(token)
    setUserId(userId)
  }

  const logout = () => {
    setToken(null)
    setUserId(null)
  }

  return (
    <BrowserRouter>
      <React.Fragment>
        <AuthContext.Provider value={{ token, userId, login, logout }}>
          <Sidebar />
          <main className="main-content">
            <Switch>
              {!token && <Redirect from="/clients" to="/" exact />}
              {!token && <Redirect from="/projects" to="/" exact />}
              {!token && <Redirect from="/invoices" to="/" exact />}
              <Route path="/clients" component={ClientPage} exact />
              <Route path="/projects" component={ProjectPage} exact />
              <Route path="/invoices" component={InvoicePage} exact />
              <Route path="/" component={HomePage} exact />
            </Switch>
          </main>
        </AuthContext.Provider>
      </React.Fragment>
    </BrowserRouter>
  )
}

export default App;

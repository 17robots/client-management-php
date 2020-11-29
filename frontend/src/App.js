import React, { useState } from 'react';
import { BrowserRouter, Route, Redirect, Switch } from 'react-router-dom'
import { Provider } from 'react-redux'
import HomePage from './pages/HomePage'
import ClientPage from './pages/Clients'
import ProjectPage from './pages/Projects'
import InvoicePage from './pages/InvoicePage'
import AuthContext from './context/auth-context'

import store from './redux/store'

import './App.css';

function App() {
  const [token, setToken] = useState(null)
  const [userId, setUserId] = useState(null)
  const [projects, setProjects] = useState([])
  const [tasks, setTasks] = useState([])
  const [milestones, setMilestones] = useState([])
  const [selectedProject, setSelectedProject] = useState(null)
  const [selectedClient, setSelectedClient] = useState(null)

  // <Link to="route" target="_blank" onClick={(event) => {event.preventDefault(); window.open(this.makeHref("route"));}} />

  login = (token, userId, tokenExpiration) => {
    setToken(token)
    setUserId(userId)
  }

  logout = () => {
    setToken(null)
    setUserId(null)
  }

  addClient = () => {

  }

  removeClient = clientId => {

  }

  editClient = clientId => {

  }

  addProject = () => {

  }

  editProject = projectId => {

  }

  removeProject = projectId => {

  }

  addMilestone = () => {

  }

  editMilestone = milestoneId => {

  }

  deleteMilestone = milestoneId => {

  }

  addTask = () => {

  }

  editTask = taskId => {

  }

  deleteTask = taskId => {

  }

  return (
    <Provider store={store}>
      <React.StrictMode>
        <BrowserRouter>
          <React.Fragment>
            <AuthContext.Provider value={{ token, userId, login, logout }}>
              <Sidebar />
              <main className="main-content">
                <Switch>
                  {!token && <Redirect from="/clients" to="/" exact />}
                  {!token && <Redirect from="/invoice" to="/" exact />}
                  {!token && <Redirect from="/projects" to="/" exact />}
                  {token && <Route path="/clients" component={ClientPage} />}
                  {token && <Route path="/projects" component={ProjectPage} />}
                  {token && <Route path="/invoice" component={InvoicePage} />}
                  {!this.state.token && <Redirect to="/" exact />}
                  <Route path="/" component={HomePage} />
                </Switch>
              </main>
            </AuthContext.Provider>
          </React.Fragment>
        </BrowserRouter>
      </React.StrictMode>
    </Provider>
  )
}

export default App;

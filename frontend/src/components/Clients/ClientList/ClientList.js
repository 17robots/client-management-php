import React from 'react'
import { connect } from 'react-redux'
import { myClientList } from '../../../redux/client/client.selectors'
import ClientItem from './ClientItem/ClientItem'

const mapStateToProps = state => ({
  clients: myClientList(state)
})


const clientList = props => (
  <ul>
    {props.clients.map(client => <ClientItem client={client} />)}
  </ul>
)

export default connect(mapStateToProps, null)(clientList)
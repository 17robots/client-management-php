import React from 'react'

export default class InvoicePage extends React.Component {
  constructor(props) {
    super(props)
  }

  state = {
    selectedProjects: [],
    selectedMilestones: [],
    totalInvoiceItems: []
  }

  render() {
    return <h1>Invoice Page</h1>
  }
}
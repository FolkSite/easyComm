easyComm.grid.Threads = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ec-grid-threads';
    }
    config.record = config.record || {};
    config.record.id = config.record.id || 0;
    Ext.applyIf(config, {
        url: easyComm.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/thread/getlist',
            resource_id: config.record.id
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateThread(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec, ri, p) {
                //return !rec.data.active ? 'ec-row-disabled' : '';
                return '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true
    });
    easyComm.grid.Threads.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(easyComm.grid.Threads, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var m = [];
        if (ids.length > 1) {
            m.push({text: '<i class="x-menu-item-icon icon icon-remove"></i>'+_('ec_threads_remove'),handler: this.removeThread});
        } else {
            m.push({text: '<i class="x-menu-item-icon icon icon-edit"></i>'+_('ec_thread_update'),handler: this.updateThread});
            m.push('-');
            m.push({text: '<i class="x-menu-item-icon icon icon-remove"></i>'+_('ec_thread_remove'),handler: this.removeThread});
        }

        this.addContextMenuItem(m);
    },

    createThread: function (btn, e) {
        var w = MODx.load({
            xtype: 'ec-thread-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({
            //active: true
        });
        w.show(e.target);
    },

    updateThread: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/thread/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'ec-thread-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeThread: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('ec_threads_remove')
                : _('ec_thread_remove'),
            text: ids.length > 1
                ? _('ec_threads_remove_confirm')
                : _('ec_thread_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/thread/remove',
                ids: Ext.util.JSON.encode(ids)
            },
            listeners: {
                success: {
                    fn: function (r) {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    disableThread: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/thread/disable',
                ids: Ext.util.JSON.encode(ids)
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    enableThread: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/thread/enable',
                ids: Ext.util.JSON.encode(ids)
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    getFields: function (config) {
        return ['id', 'resource', 'name', 'title', 'count', 'actions'];
    },

    getColumns: function (config) {
        return [{
            header: _('ec_thread_id'),
            dataIndex: 'id',
            sortable: true,
            width: 70
        }, {
            header: _('ec_thread_resource'),
            dataIndex: 'resource',
            sortable: true,
            width: 70
        }, {
            header: _('ec_thread_name'),
            dataIndex: 'name',
            sortable: true,
            width: 150
        }, {
            header: _('ec_thread_title'),
            dataIndex: 'title',
            sortable: true,
            width: 200
        }, {
            header: _('ec_thread_count'),
            dataIndex: 'count',
            sortable: true,
            width: 70
        }];
    },

    getTopBar: function (config) {
        return [{
            text: '<i class="icon icon-plus"></i> ' + _('ec_thread_create'),
            handler: this.createThread,
            scope: this
        }, '->', {
            xtype: 'textfield',
            name: 'query',
            width: 200,
            id: config.id + '-search-field',
            emptyText: _('ec_grid_search'),
            listeners: {
                render: {
                    fn: function (tf) {
                        tf.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
                            this._doSearch(tf);
                        }, this);
                    }, scope: this
                }
            }
        }, {
            xtype: 'button',
            id: config.id + '-search-clear',
            text: '<i class="icon icon-times"></i>',
            listeners: {
                click: {fn: this._clearSearch, scope: this}
            }
        }];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },

    _clearSearch: function (btn, e) {
        this.getStore().baseParams.query = '';
        Ext.getCmp(this.config.id + '-search-field').setValue('');
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});
Ext.reg('ec-grid-threads', easyComm.grid.Threads);
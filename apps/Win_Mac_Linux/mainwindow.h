#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QTreeWidgetItem>
#include <QVariantList>
#include <QMainWindow>
#include <QObject>
#include <QEvent>
#include "apifuncs.h"
#include "jsonfuncs.h"
#include "cachefuncs.h"

namespace Ui {
class MainWindow;
}

class MainWindow : public QMainWindow
{
    Q_OBJECT

private:
    Ui::MainWindow *ui;
    ApiFuncs *apiFuncs;
    JsonFuncs *jsonFuncs;
    CacheFuncs *cacheFuncs;
    QTreeWidgetItem *group;

public:
    explicit MainWindow(QWidget *parent = 0);
    void Initialize();
    void FillListWithSnippets(QVariantList a_jsonObject);
    ~MainWindow();

private slots:
    void on_aboutSnippt_triggered();
    void ShowSelectedSnippet(QTreeWidgetItem *a_item, int a_column);
    void on_copySnippet_clicked();
};

#endif // MAINWINDOW_H